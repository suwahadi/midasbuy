<?php

namespace App\Http\Controllers;

use App\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// use Pusher\Pusher;
// use Illuminate\Support\Facades\Mail;

class APIController extends Controller
{

  public function SendServerAPI () {
  $trx = DB::table('transactions')
  ->where('status', '1')
  ->where('notes', NULL)
  ->get();

  if (count($trx)) {
    foreach ($trx as $trxs) {
        $trx_id = $trxs->trx_id;
        $idtrx = $trxs->id;
        $product_id = $trxs->product_id;
        $product_code = $trxs->product_code;
        $game_id = $trxs->game_id;
        $email = $trxs->email;
        $phone = $trxs->phone;

    // Send to API Server
    $curl = curl_init();
    $api_key = "authorization: Bearer ".config('transaction_api_key');
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://vouchergame.id/api/order",
      //CURLOPT_URL => "http://localhost/codashop/public/api/order",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"product\"\r\n\r\n$product_code\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data;  name=\"game_id\"\r\n\r\n$game_id\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"phone\"\r\n\r\n$phone\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW\r\nContent-Disposition: form-data; name=\"email\"\r\n\r\n$email\r\n------WebKitFormBoundary7MA4YWxkTrZu0gW--",
      CURLOPT_HTTPHEADER => array(
        $api_key,
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
      ),
    ));

    $response = curl_exec($curl);
    //echo $response;
    $err = curl_error($curl);
    curl_close($curl);

    $json = json_decode($response, TRUE);

    //print_r($response.'<br><br>');

    print_r($json['status'].'<br>');

    // jika error (saldo kurang)
    if ($json['status'] == 'error') {
      print_r($json['message']);
    } else {
      print_r($json['data'][0]['date'].'<br>');
      print_r($json['data'][0]['trx_id'].'<br>');
      print_r($json['data'][0]['total'].'<br>');
      print_r($json['data'][0]['product'].'<br>');
      print_r($json['data'][0]['game_id'].'<br>');
      print_r($json['data'][0]['phone'].'<br>');
      print_r($json['data'][0]['email'].'<br>');
      print_r($json['data'][0]['status'].'<br>');

      $trx_id_api = $json['data'][0]['trx_id'];

      // Update trx diproses API
      $updatetrx = Transactions::where('status', '1')
        ->where('trx_id', $trx_id)
        ->where('product_id', $product_id)
        ->where('product_code', $product_code)
        ->update(['status' => '5', 'notes' => $trx_id_api]); // Diproses API
    }
} 

} else {
  return "no transaction waiting to process...";
}

}



public function CheckAPI () {

  $trx = DB::table('transactions')
  ->where('status', '5')
  ->get();

  if (count($trx)) {
    foreach ($trx as $trxs) {
      $trx_id_api = $trxs->notes;
      $idtrx = $trxs->id;
      $product_id = $trxs->product_id;
      $product_code = $trxs->product_code;
      $game_id = $trxs->game_id;
      $email = $trxs->email;
      $phone = $trxs->phone;

      $curl = curl_init();
      $api_key = "authorization: Bearer ".config('transaction_api_key');
      $trx_id_api = $trx_id_api;
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://vouchergame.id/api/history/".$trx_id_api,
      //CURLOPT_URL => "http://localhost/codashop/public/api/history/".$trx_id_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        $api_key,
        "cache-control: no-cache",
        "content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW",
      ),
      ));
      $response = curl_exec($curl);
      $err = curl_error($curl);
      curl_close($curl);

    if ($response) {
      $json = json_decode($response, TRUE);
      // print_r($json['status'].'<br>');
      // print_r($json['data'][0]['date'].'<br>');
      // print_r($json['data'][0]['trx_id'].'<br>');
      // print_r($json['data'][0]['total'].'<br>');
      // print_r($json['data'][0]['product'].'<br>');
      // print_r($json['data'][0]['game_id'].'<br>');
      // print_r($json['data'][0]['phone'].'<br>');
      // print_r($json['data'][0]['email'].'<br>');
      // print_r($json['data'][0]['status'].'<br>');

      $trx_id_api = $json['data'][0]['trx_id'];
      $status_api = $json['data'][0]['status'];

      //Jika Sukses
      if ($status_api == '2') {
      $updatetrx = Transactions::where('status', '5')
        ->where('notes', $trx_id_api)
        ->where('product_code', $product_code)
        ->update(['status' => '2']); // Sukses
        print_r("transaction id #".$trxs->trx_id.' success...<br>');

      } elseif ($status_api == '1') {
        print_r("transaction id #".$trxs->trx_id.' on proccess...<br>');
      } elseif ($status_api == '3') {
        $updatetrx = Transactions::where('status', '5')
        ->where('notes', $trx_id_api)
        ->where('product_code', $product_code)
        ->update(['status' => '3']); // Gagal
        print_r("transaction id #".$trxs->trx_id.' failed...<br>');
      }
      
    } else {
      'Terjadi kesalahan...';
    }
  }
 
  
  } else {
    return "no transaction waiting to check...";
  }

}


}