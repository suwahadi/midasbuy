<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Deposit;
use App\UserLogs;
use App\PaymentChannels;

class UserController extends Controller
{

    use AuthenticatesUsers;

    //protected $redirectTo = '/profile';

    public function __construct()
    {
        $this->middleware('auth')->except('/');

        // Set status deposit expired START
        date_default_timezone_set('Asia/Jakarta');
        $skrg = date('Y-m-d H:i:s');
        $timeskrg = strtotime($skrg);
        $datatrx = Deposit::all();
        $datatrx = Deposit::where('status', '0')->get();
        foreach ($datatrx as $tx) {
            $trxid = $tx->id;
            $trxstatus = $tx->status;
            $timetrx = strtotime($tx->created_at);
            $timeexpired = $timetrx + config('payment_expired_time');
            if ($timeskrg > $timeexpired) {
                $updatestatus = Deposit::where('id', $trxid)->update(array('status' => '2'));
            }
        }
        // Set status deposit expired END
    }

    public function index()
    {
        $userid = auth()->user()->id;
        
        $logs = DB::table('users_logs')->where([
            ['userid', '=', $userid]
        ])->limit(20)->orderBy('id', 'desc')->get();

        return view('profile', compact('logs'));
    }

    public function deposit()
    {
        $userid = auth()->user()->id;
        
        $datas = DB::table('deposit')->where([
            ['userid', '=', $userid]
        ])->limit(20)->orderBy('id', 'desc')->get();

        return view('deposit', compact('datas'));
    }

    public function depositDetail ($id)
    {
        $userid = auth()->user()->id;
        
        $datas = DB::table('deposit')->where([
            ['userid', '=', $userid],
            ['id', '=', $id]
        ])->limit(1)->orderBy('id', 'desc')->first();

        $paymentid = $datas->payment_channel;
        $payment = DB::table('payment_channels')->where([
            ['id', '=', $paymentid],
        ])->first();

        return view('deposit-detail', [
            'datas' => $datas,
            'payment' => $payment
        ]);
    }

    public function history()
    {
        $userid = auth()->user()->id;
        
        $datas = DB::table('transactions')->where([
            ['user_id', '=', $userid]
        ])->limit(20)->orderBy('id', 'desc')->get();

        return view('history', compact('datas'));
    }

    public function edit()
    {
        $userid = auth()->user()->id;
        
        $datas = DB::table('transactions')->where([
            ['user_id', '=', $userid]
        ])->limit(20)->orderBy('id', 'desc')->get();

        return view('profile-edit', compact('datas'));
    }

    public function saveProfile (Request $request)
    {
        $userid = auth()->user()->id;
        $user = DB::table('users')->where([
            ['id', '=', $userid]
        ])->first();
        
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required'],
            'phone' => ['required'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors(['Informasi yang Anda masukkan kurang lengkap!', '']);
        }

        if ($request->password != $user->password) {
            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }

        // update data user
        DB::table('users')->where('id',$userid)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password
        ]);
        return redirect('profile')->with('alert-success','Profile Anda telah berhasil diperbarui...');
    }

    public function storeDeposit (Request $request)
    {

        $unik = str_pad(rand(0,999), 3, "0", STR_PAD_LEFT);

        $validator = Validator::make($request->all(), [
            'user_id' => ['required'],
            'amount' => ['required'],
            'channel' => ['required'],
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors(['Informasi yang Anda masukkan kurang lengkap!', '']);
        }

        $data = new Deposit();
        $data->userid = $request->user_id;
        $data->total = $request->amount+$unik;
        $data->payment_channel = $request->channel;
        $data->status = '0';
        $data->save();
        
        $user = DB::table('users')->where([
            ['id', '=', $data->userid],
        ])->first();

        $user_id = $user->id;
        $user_name = $user->name;
        $user_email = $user->email;
        $user_phone = $user->phone;

        $paymentchannels = DB::table('payment_channels')->where([
            ['id', '=', $data->payment_channel],
        ])->first();

        $amount =  $data->total+$paymentchannels->mark_up_price;
        $merchantRef = $data->id;
        $sku = 'TOPUP#'.$data->id;
        $name = 'Topup '.config('webname').' IDR '.number_format($data->total, 0);

        // START Payment Gateway
        if ($data->payment_channel == 1){
            $channel = 'QRIS';
        } elseif ($data->payment_channel == 3){
            $channel = 'BNIVA';
        } elseif ($data->payment_channel == 4){
            $channel = 'QRIS';
        } elseif ($data->payment_channel == 5){
            $channel = 'ALFAMART';
        } elseif ($data->payment_channel == 6){
            $channel = 'INDOMARET';
        }elseif ($data->payment_channel == 7){
            $channel = 'QRIS';
        }elseif ($data->payment_channel == 9){
            $channel = 'MANDIRIVA';
        }elseif ($data->payment_channel == 10){
            $channel = 'BNIVA';
        }elseif ($data->payment_channel == 11){
            $channel = 'BRIVA';
        }

            if ($data->payment_channel == 3 OR $data->payment_channel == 4 OR $data->payment_channel == 5 OR $data->payment_channel == 6 OR $data->payment_channel == 7 OR $data->payment_channel == 9 OR $data->payment_channel == 10 OR $data->payment_channel == 11)
            {
                $apiKey = config('payment_api_key');
                $privateKey = config('payment_private_key');
                $merchantCode = config('payment_merchant_code');
                $signature = hash_hmac('sha256', $merchantCode.$merchantRef.$amount, $privateKey);
                $data = [
                'method'            => $channel,
                'merchant_ref'      => $merchantRef,
                'amount'            => $amount,
                'customer_name'     => $user_name,
                'customer_email'    => $user_email,
                'customer_phone'    => $user_phone,
                'order_items'       => [
                    [
                    'sku'       => $sku,
                    'name'      => $name,
                    'price'     => $amount,
                    'quantity'  => 1
                    ]
                ],
                'callback_url'      => config('payment_callback_url'),
                'return_url'        => url('deposit/'.$data->id),
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
                    $hapusdepo = DB::table('deposit')->where('id',$merchantRef)->delete();
                    return redirect('profile')->with('error','Deposit gagal! '.$message);
                } else {
                    $paymentredirect = $json['data']['checkout_url'];
                    $reference = $json['data']['reference'];

                    Deposit::where('id', $merchantRef)
                        ->where('status', 0)
                        ->update(['payment_ref' => $reference]);

                    return redirect($paymentredirect);
                }
            }
            // END Payment Gateway

             // Start Bank Payment
            else if ($data->payment_channel == 1 OR $data->payment_channel == 2 OR $data->payment_channel == 8 OR $data->payment_channel == 9 OR $data->payment_channel == 10 OR $data->payment_channel == 11) {

                // Tambahkan Angka Unik:
                $unik = str_pad(rand(0,500), 3, "0", STR_PAD_LEFT);
                $depoupd = Deposit::where('id', $merchantRef)
                    ->where('payment_channel', $data->payment_channel)
                    ->update(['total' => $data->total+$unik]);
                    return redirect('deposit/'.$data->id);
                // End Bank Payment
            }

    }

}