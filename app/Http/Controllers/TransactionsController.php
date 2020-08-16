<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\DB;
use App\Transactions;
use App\User;
use App\UserLogs;
use Illuminate\Support\Facades\Auth;
use Pusher\Pusher;
use Illuminate\Support\Facades\Mail;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

class TransactionsController extends Controller
{

    public function __construct()
    {
        // Set status apabila expired START
        date_default_timezone_set('Asia/Jakarta');
        $skrg = date('Y-m-d H:i:s');
        $timeskrg = strtotime($skrg);
        $datatrx = Transactions::all();
        $datatrx = Transactions::where('status', '0')->get();
        foreach ($datatrx as $tx) {
            $trxid = $tx->id;
            $trxstatus = $tx->status;
            $timetrx = strtotime($tx->created_at);
            $timeexpired = $timetrx + config('payment_expired_time');
            if ($timeskrg > $timeexpired) {
                $updatestatus = Transactions::where('id', $trxid)->update(array('status' => '4'));
            }
        }
        // Set status apabila expired END
    }


    public function cektrx()
    {
        // Set status apabila expired START
        date_default_timezone_set('Asia/Jakarta');
        $skrg = date('Y-m-d H:i:s');
        $timeskrg = strtotime($skrg);
        $datatrx = Transactions::all();
        $datatrx = Transactions::where('status', '0')->get();
        foreach ($datatrx as $tx) {
            $trxid = $tx->id;
            $trxstatus = $tx->status;
            $timetrx = strtotime($tx->created_at);
            $timeexpired = $timetrx + config('payment_expired_time');
            if ($timeskrg > $timeexpired) {
                $updatestatus = Transactions::where('id', $trxid)->update(array('status' => '4'));
            }
        }
        // Set status apabila expired END
        return 'cek trx done...';
    }


   public function store(Request $request)
   {

    $validator = Validator::make($request->all(), [
        'productID' => ['required'],
        'productCode' => ['required'],
        'price' => ['required'],
        'phone' => ['required'],
        'email' => ['required'],
    ]);

    if ($request->game_id2) {
        $game_id = $request->game_id.' ('.$request->game_id2.')';
    }else{
        $game_id = $request->game_id;
    }

    if ($validator->fails()) {
        return Redirect::back()->withErrors(['Informasi yang Anda masukkan kurang lengkap!', '']);
    }

    $data = [
        'game_id'       => $request->game_id,
        'productID'     => $request->productID,
        'productCode'   => $request->productCode,
        'email'         => $request->email,
        'phone'         => $request->phone,
        'channel'       => $request->channel,
        'price'         => $request->price,
    ];

    // Start Validasi Harga
    if (Auth::guest()) {

        $vitems= DB::table('items')->where('id', $data['productID'])->first();
        $vprice1 = $vitems->price_reguler;

        $productID = $vitems->id;
        $product_code = $vitems->code;

        $vchannels = DB::table('payment_channels')->where('id', $data['channel'])->first();
        $vmarkup1 = $vchannels->mark_up_price;

        $n1 = $vprice1+$vmarkup1;
        $amount = $request->price;

        if ($data['price'] != $n1) {
            return Redirect::back()->withErrors(['Informasi yang Anda masukkan kurang lengkap!', '']);
        }

    } elseif (Auth::user()) {

        $produk = DB::table('items')->where('id', $request->productID)->first();
        $member = DB::table('users')->where('id', $request->user_id)->first();
        
        $productID = $produk->id;
        $product_code = $produk->code;

        $typemember = $member->type;
        if ($typemember == 0) {
            $vharga = DB::table('items')->where('id', $request->productID)->first();
            if ($vharga->price_reguler != $request->price) {
                return Redirect::back()->withErrors(['Informasi yang Anda masukkan kurang lengkap!', '']);
            } else {
                $amount = $produk->price_reguler;
            }
            
        } elseif ($typemember == 1) {
            $vharga = DB::table('items')->where('id', $request->productID)->first();
            if ($vharga->price_reseller != $request->price) {
                return Redirect::back()->withErrors(['Informasi yang Anda masukkan kurang lengkap!', '']);
            } else {
                $amount = $produk->price_reseller;
            }
        }
        
    }
    // End Validasi Harga
    
        $data = new Transactions();
        $data->user_id = $request->user_id;
        $data->trx_id = substr (strtotime("now"), -6);
        $data->product_id = $productID;
        $data->product_code = $product_code;
        $data->game_id = $game_id;
        $data->phone = $request->phone;
        $data->email = $request->email;
        $data->total = $amount;
        $data->payment_channel_id = $request->channel;
        $data->status = '0'; // 0 => Waiting; 1 => Process, 2 => Success, 3 => Failed, 4 => Expired
        $data->save();

        $merchantRef = $data->trx_id;
        $userid = $data->user_id;

        $vproducts = DB::table('items')->where('id', $data->product_id)->first();
        //dd($data);
        //dd($vproducts);
        $vproductsname = $vproducts->name;

        // START Payment Gateway
        if ($data->payment_channel_id == 1){
            $channel = 'QRIS';
        } elseif ($data->payment_channel_id == 3){
            $channel = 'BNIVA';
        } elseif ($data->payment_channel_id == 4){
            $channel = 'QRIS';
        } elseif ($data->payment_channel_id == 5){
            $channel = 'ALFAMART';
        } elseif ($data->payment_channel_id == 6){
            $channel = 'INDOMARET';
        }elseif ($data->payment_channel_id == 7){
            $channel = 'QRIS';
        }elseif ($data->payment_channel_id == 9){
            $channel = 'MANDIRIVA';
        }elseif ($data->payment_channel_id == 10){
            $channel = 'BNIVA';
        }elseif ($data->payment_channel_id == 11){
            $channel = 'BRIVA';
        }

        if ($data->payment_channel_id == 3 OR $data->payment_channel_id == 4 OR $data->payment_channel_id == 5 OR $data->payment_channel_id == 6 OR $data->payment_channel_id == 7 OR $data->payment_channel_id == 9 OR $data->payment_channel_id == 10 OR $data->payment_channel_id == 11)
        {
            $apiKey = config('payment_api_key');
            $privateKey = config('payment_private_key');
            $merchantCode = config('payment_merchant_code');
            $signature = hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey);
            $data = [
            'method'            => $channel,
            'merchant_ref'      => $merchantRef,
            'amount'            => $amount,
            'customer_name'     => $data->phone,
            'customer_email'    => $data->email,
            'customer_phone'    => $data->phone,
            'order_items'       => [
                [
                'sku'       => $data->product_code,
                'name'      => $vproductsname,
                'price'     => $amount,
                'quantity'  => 1
                ]
            ],
            'callback_url'      => config('payment_callback_url'),
            'return_url'        => url('order').'/'.$data->trx_id,
            'expired_time'      => (time()+(config('payment_expired_time'))),
            'signature'         => $signature
            ];

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => config('payment_post_url'),
            CURLOPT_RETURNTRANSFER    => true,
            CURLOPT_HEADER            => false,
            CURLOPT_HTTPHEADER        => array(
                "Authorization: Bearer ".$apiKey
            ),
            CURLOPT_FAILONERROR       => false,
            CURLOPT_POST              => true,
            CURLOPT_POSTFIELDS        => http_build_query($data)
            ));
            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            $json = json_decode($response, TRUE);

            $cekstatus = ($json['success']);
            $message = ($json['message']);

            if ($cekstatus != '1' OR $response == 'false') {
                $hapustrx = DB::table('transactions')->where('trx_id',$merchantRef)->delete();
                return redirect()->back()->with('error','Transaksi gagal! '.$message);
            } else {
                $paymentredirect = $json['data']['checkout_url'];
                $reference = $json['data']['reference'];
                Transactions::where('trx_id', $merchantRef)
                    ->where('status', 0)
                    ->update(['payment_ref' => $reference]);
                return redirect($paymentredirect);
            }
         // END Payment Gateway

         // Start Bank Payment
        } else if ($data->payment_channel_id == 1 OR $data->payment_channel_id == 2 OR $data->payment_channel_id == 8) {

            // Tambahkan Angka Unik:
            $unik = str_pad(rand(0,500), 3, "0", STR_PAD_LEFT);
            $trxupd = Transactions::where('trx_id', $merchantRef)
                ->where('payment_channel_id', $data->payment_channel_id)
                ->update(['total' => $data->total+$unik]);
                return redirect('order/'.$merchantRef)->with('alert-success','Transaksi sukses dibuat!');
        // End Bank Payment

        // Start Transfer Pulsa
        } else if ($data->payment_channel_id == 12) {

            // Tambahkan Angka Unik:
            // $unik = str_pad(rand(0,500), 3, "0", STR_PAD_LEFT);
            // $trxupd = Transactions::where('trx_id', $merchantRef)
            //     ->where('payment_channel_id', $data->payment_channel_id)
            //     ->update(['total' => $data->total+$unik]);
                return redirect('order/'.$merchantRef)->with('alert-success','Transaksi sukses dibuat!');
        // End Transfer Pulsa

        } else {

            // START Cek Saldo User
            $users = User::where('id', $userid)
                ->where('status', 1)
                ->first();
            $balance = $users->balance;

            if ($balance < $amount) {
                $hapustrx = DB::table('transactions')->where('trx_id',$merchantRef)->delete();
                return redirect()->back()->with('error','Transaksi gagal. Saldo tidak cukup!');
            } else {
                // Kurangi Saldo User:
                $setbalance = $balance-$amount;
                User::where('id', $userid)
                    ->where('status', 1)
                    ->update(['balance' => $setbalance]);

                Transactions::where('trx_id', $merchantRef)
                ->where('user_id', $userid)
                ->update(['status' => 1, 'payment_channel_id' => 0]);

                // Masukkan ke Logs:
                $data1 = new UserLogs();
                $data1->userid = $userid;
                $data1->total = $amount;
                $data1->type = 'Debet';
                $data1->notes = 'Order '.$product_code;
                $data1->balance = $setbalance;
                $data1->save();

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
                $data['message'] = 'Transaksi baru: #'.$merchantRef.' ('.$product_code.') dari member, silahkan diproses...';
                $pusher->trigger('notifikasi', 'App\\Events\\Notify', $data);

                // Notifikasi Email Admin:
                $datanotif = [
                    'trx_id'    => $merchantRef,
                    'code'      => $product_code,
                    'timetrx'   => $data->created_at,
                    'subject'   => 'Transaksi Divalidasi: #'.$merchantRef
                ];
                Mail::send('mail', $datanotif, function($message) use ($datanotif)
                    {
                        $message->from('cs@midasbuy.id','CS MIDASBUY');
                        $message->to('cs@midasbuy.id','CS MIDASBUY');
                        $message->subject($datanotif['subject']);
                    });

                return redirect('order/'.$merchantRef)->with('alert-success','Transaction success!');
            }
            // END Cek Saldo User
        }

   }


    public function getStatus($trx_id)
    {
        $transaction = DB::table('transactions')->where([
            ['trx_id', '=', $trx_id],
        ])->first();

        if ($transaction == NULL) {
            return redirect()->route('frontpage');
        }

        $productid = $transaction->product_id;
        $product = DB::table('items')->where([
            ['id', '=', $productid],
        ])->first();

        $paymentid = $transaction->payment_channel_id;
        $payment = DB::table('payment_channels')->where([
            ['id', '=', $paymentid],
        ])->first();

        if ($transaction) {
            return view('status', [
                'transaction' => $transaction,
                'product' => $product,
                'payment' => $payment,
            ]);
        } else {
            return redirect()->route('frontpage');
        }
    }

}