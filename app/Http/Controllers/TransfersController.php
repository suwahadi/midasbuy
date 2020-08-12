<?php

namespace App\Http\Controllers;

use App\Transfers;
use App\Transactions;
use App\Deposit;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pusher\Pusher;
use Illuminate\Support\Facades\Mail;

class TransfersController extends Controller
{

  public function store(Request $request) {

  	if ( $request->api_bank_key != config('api_bank_key') ) {
  	        return response()->json([
              'status' => 'error',
              'message' => 'invalid api bank key!'
          ], 401);
  	} else {

    date_default_timezone_set('Asia/Jakarta');
    $waktu = date('Y-m-d H:i:s');
    $tgl = $request->date;
    $jam = $request->time;
    $bank = $request->bank;
    $total = $request->total;
    $data = $request->data;
    $created_at = $waktu;

    if ($bank == 'bca') {
        $jenisbank = '8';
      } elseif ($bank == 'mandiri') {
        $jenisbank = '9';
      } elseif ($bank == 'bri') {
        $jenisbank = '11';
      } elseif ($bank == 'bni') {
        $jenisbank = '10';
      } elseif ($bank == 'ovo') {
        $jenisbank = '2';
      } elseif ($bank == 'gopay') {
        $jenisbank = '1';
    }

    $DataMutasi = DB::table('transfers')->insert([
        'bank' => $bank,
        'total' => $total,
        'data' => $data,
        'date' => $tgl,
        'time' => $jam,
        'created_at' => $created_at,
    ]);

      $depo = DB::table('deposit')
            ->where('total', '=', $total)
            ->where('status', '=', '0')
            ->where('payment_channel', '=', $jenisbank)
            ->get();

      foreach ($depo as $datadeposit) {
        $depositid = $datadeposit->id;
        $userid = $datadeposit->userid;
        $nominaldeposit = $datadeposit->total;
        $statusdeposit = $datadeposit->status;
      }

      if (count($depo)) {

          $type = 'Credit';
          $notes = 'Topup Saldo #'.$depositid;

          $Users = User::all();
          $Users = User::where('id', $userid)->get();

          foreach ($Users as $User) {
              $balance_start = $User->balance;
          }

          $balance_end = $balance_start + $total;

          $matchDepo = ['userid' => $userid, 'total' => $total, 'status' => '0'];
          $updatedeposit = Deposit::where($matchDepo)->update(array('status' => '1'));
          $updatebalance = User::where('id', $userid)->update(array('balance' => $balance_end));

          // Push Notifikasi Admin:
        $options = array(
          'cluster' => env('PUSHER_APP_CLUSTER'),
          'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'), 
            $options
        );
        $notif['message'] = 'Topup Saldo: ID #'.$depositid.' (Rp '.number_format($nominaldeposit, 0).')  sukses divalidasi via '.strtoupper($bank).', silahkan dicek...';
        $pusher->trigger('notifikasi', 'App\\Events\\Notify', $notif);

        DB::table('users_logs')->insert([
            'userid' => $userid,
            'total' => $total,
            'type' => $type,
            'notes' => $notes,
            'balance' => $balance_end,
            'created_at' => $waktu,
        ]);

        return response()->json([
            'status' => 'success',
            'data' => ([
            'balance_start' => $balance_start,
            'total' => $total,
            'balance_end' => $balance_end,
            ])
        ], 200);
      
      }


      // Transaksi START
      $trx = DB::table('transactions')
            ->where('total', $total)
            ->where('status', '0')
            ->where('payment_channel_id', $jenisbank)
            ->get();

      foreach ($trx as $trxs) {
        $idtrx = $trxs->id;
        $jenisbank = $trxs->payment_channel_id;
        $totaltrx = $trxs->total;
        $trx_id = $trxs->trx_id;
        $product_code = $trxs->product_code;
        $created_at = $trxs->created_at;
      }

      if (count($trx)) {

      $matchTrx = ['id' => $idtrx, 'status' => '0', 'payment_channel_id' => $jenisbank, 'total' => $totaltrx];
      $updateTrx = Transactions::where($matchTrx)->update(array('status' => '1')); // Diproses

      // Push Notifikasi Admin:
        $options = array(
          'cluster' => env('PUSHER_APP_CLUSTER'),
          'encrypted' => true
      );
      $pusher = new Pusher(
          env('PUSHER_APP_KEY'),
          env('PUSHER_APP_SECRET'),
          env('PUSHER_APP_ID'), 
          $options
      );
      $notif['message'] = 'Transaksi: ID #'.$trx_id.' ('.$product_code.') pembayaran sukses divalidasi via '.strtoupper($bank).', silahkan diproses...';
      $pusher->trigger('notifikasi', 'App\\Events\\Notify', $notif);

      // Notifikasi Email Admin:
        $datanotif = [
          'trx_id'    => $trx_id,
          'code'      => $product_code,
          'timetrx'   => $created_at,
          'subject'   => 'Transaksi Divalidasi: #'.$trx_id
      ];
      Mail::send('mail', $datanotif, function($message) use ($datanotif)
          {
            $message->from('cs@midasbuy.id','CS MIDASBUY');
            $message->to('cs@midasbuy.id','CS MIDASBUY');
            $message->subject($datanotif['subject']);
          });

      return response()->json([
        'status' => 'success',
        'data' => ([
        'trx_id' => $trx_id,
        'total' => $totaltrx,
        'product_code' => $product_code
        ])
      ], 200);
      // Transaksi END

      } else{

        return response()->json([
            'status' => 'success',
            'data' => $trx
        ], 402);
      }

	}
    
  }



  public function callbackpayment (Request $request) {

    $privateKey = config('payment_private_key');
    
    $json = file_get_contents("php://input");

    $callbackSignature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';

    $signature = hash_hmac('sha256', $json, $privateKey);

    // if( $callbackSignature !== $signature ) {
    //     exit("Invalid Signature");
    // }

    $data = json_decode($json);
    $event = $_SERVER['HTTP_X_CALLBACK_EVENT'];

    if( $event == 'payment_status' )
    {
        if( $data->status == 'PAID' )
        $total = $data->total_amount;
        $received = $data->amount_received;
        $reference = $data->reference;

        if ($data->payment_method_code == 'ALFAMART') {
          $jenischannel = '5';
        }elseif ($data->payment_method_code == 'INDOMARET') {
          $jenischannel = '6';
        }elseif ($data->payment_method_code == 'MANDIRIVA') {
          $jenischannel = '9';
        }elseif ($data->payment_method_code == 'BNIVA') {
          $jenischannel = '10';
        }elseif ($data->payment_method_code == 'BRIVA') {
          $jenischannel = '11';
        }

          $trx = DB::table('transactions')
            ->where('total', $total)
            ->where('status', '0')
            ->where('payment_channel_id', $jenischannel)
            ->where('payment_ref', $reference)
            ->get();

            foreach ($trx as $trxs) {
              $idtrx = $trxs->id;
              $channel = $trxs->payment_channel_id;
              $totaltrx = $trxs->total;
              $trx_id = $trxs->trx_id;
              $product_code = $trxs->product_code;
              $created_at = $trxs->created_at;
            }
      
            if (count($trx)) {
              // Jika pembayaran sukses, update transaksi:
              $matchTrx = ['id' => $idtrx, 'status' => '0', 'payment_channel_id' => $channel, 'total' => $totaltrx, 'payment_ref' => $reference];
              $updateTrx = Transactions::where($matchTrx)->update(array('status' => '1')); // Diproses

              echo json_encode(['success' => true]); // berikan respon yang sesuai

              // Push Notifikasi Admin:
                $options = array(
                  'cluster' => env('PUSHER_APP_CLUSTER'),
                  'encrypted' => true
              );

              $pusher = new Pusher(
                  env('PUSHER_APP_KEY'),
                  env('PUSHER_APP_SECRET'),
                  env('PUSHER_APP_ID'), 
                  $options
              );

              $notif['message'] = 'Transaksi: ID #'.$trx_id.' ('.$product_code.') pembayaran sukses divalidasi via '.strtoupper($data->payment_method).', silahkan diproses...';
              $pusher->trigger('notifikasi', 'App\\Events\\Notify', $notif);

              // Notifikasi Email Admin:
              $datanotif = [
                  'trx_id'    => $trx_id,
                  'code'      => $product_code,
                  'timetrx'   => $created_at,
                  'subject'   => 'Transaksi Divalidasi: #'.$trx_id
              ];
              Mail::send('mail', $datanotif, function($message) use ($datanotif)
                  {
                    $message->from('cs@midasbuy.id','CS MIDASBUY');
                    $message->to('cs@midasbuy.id','CS MIDASBUY');
                    $message->subject($datanotif['subject']);
                  });
            }

        
        $depo = DB::table('deposit')
            ->where('status', '=', '0')
            ->where('payment_channel', '=', $jenischannel)
            ->where('payment_ref', $reference)
            ->get();

      foreach ($depo as $datadeposit) {
        $depositid = $datadeposit->id;
        $userid = $datadeposit->userid;
        $nominaldeposit = $datadeposit->total;
        $statusdeposit = $datadeposit->status;
      }

      if (count($depo)) {

          $type = 'Credit';
          $notes = 'Topup Saldo #'.$depositid;

          $Users = User::all();
          $Users = User::where('id', $userid)->get();

          foreach ($Users as $User) {
              $balance_start = $User->balance;
          }

          $balance_end = $balance_start + $nominaldeposit;

          echo json_encode(['success' => true]); // berikan respon yang sesuai

          $matchDepo = ['userid' => $userid, 'total' => $nominaldeposit, 'status' => '0', 'payment_ref' => $reference];
          $updatedeposit = Deposit::where($matchDepo)->update(array('status' => '1'));
          $updatebalance = User::where('id', $userid)->update(array('balance' => $balance_end));

        // Push Notifikasi Admin:
        $options = array(
          'cluster' => env('PUSHER_APP_CLUSTER'),
          'encrypted' => true
        );
        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'), 
            $options
        );
        $notif['message'] = 'Topup Saldo: ID #'.$depositid.' (Rp '.number_format($nominaldeposit, 0).')  sukses divalidasi via '.strtoupper($data->payment_method).', silahkan dicek...';
        $pusher->trigger('notifikasi', 'App\\Events\\Notify', $notif);

        $waktu = date('Y-m-d H:i:s');
        DB::table('users_logs')->insert([
            'userid' => $userid,
            'total' => $nominaldeposit,
            'type' => $type,
            'notes' => $notes,
            'balance' => $balance_end,
            'created_at' => $waktu,
        ]);

        }

    }
  }

}