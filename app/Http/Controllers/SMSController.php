<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Redirect;
use Illuminate\Support\Facades\DB;
use App\SMSNotif;
use App\Transactions;
use App\Transfers;
use Pusher\Pusher;
use Illuminate\Support\Facades\Mail;

class SMSController extends Controller
{
    public function checkinboxsms() {
        $filters = [
            "filters" => [
            [
                [
                    "field" => "status",
                    "operator" => "=",
                    "value" => "received"
                ],
            ],
        
            ], 
            "order_by" => [
                [
                    "field" => "created_at",
                    "direction" => "desc"
                ]
            ],
            "limit" => 3,
            "offset" => 0
         ];

        $token = config('api_sms');

        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS =>json_encode($filters),
        
            CURLOPT_HTTPHEADER => array(
                "authorization: $token",
                "cache-control: no-cache"
            ),
        ));
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {

            $data = json_decode($response, true);
            $items = $data['results'];

            foreach($items as $item) {
                $inbox = new SMSNotif();
                $inbox['device_id'] = $item['device_id'];
                $inbox['type'] = 'Inbox';
                $inbox['sms_id'] = $item['id'];
                $inbox['phone_number'] = $item['phone_number'];
                $inbox['message'] = $item['message'];
                $inbox['status'] = $item['status'];
                $collection = SMSNotif::where('sms_id', $inbox['sms_id'])->first();

                if ($collection) {
                } else {
                    $inbox->save();

                    $re = '/(Anda mendapatkan penambahan pulsa Rp )(\d*)( dari nomor )(\d*)( tgl)/m';
                    $str = $inbox['message'];
                    
                    if (preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0)) {
                        $nominaltransferpulsa = $matches[0][2];
                        $pengirimtransferpulsa = $matches[0][4];
                    
                        // Jika ditemukan transaksi Transfer Pulsa START
                        $datatrx = Transactions::where('status', '0')
                        ->where('payment_channel_id', '12')
                        ->where('total', $nominaltransferpulsa)
                        ->where('payment_ref', $pengirimtransferpulsa)
                        ->first();

                        if ($datatrx) {
                            $pengirimpulsa = $datatrx->payment_ref;
                            $nominalpulsa = $datatrx->total;
    
                            $filters = [
                                'filters' => [
                                    [
                                        [
                                            'field' => 'phone_number',
                                            'operator' => '=',
                                            'value' => '858'
                                        ],
                                        [
                                            'field' => 'message',
                                            'operator' => 'LIKE',
                                            'value' => '%Anda mendapatkan penambahan pulsa Rp %'.$nominalpulsa.'%'
                                        ],
                                        [
                                            'field' => 'message',
                                            'operator' => 'LIKE',
                                            'value' => '%dari nomor '.$pengirimpulsa.'%'
                                        ],
                                        [
                                            'field' => 'status',
                                            'operator' => '=',
                                            'value' => 'received'
                                        ]
                                    ],
                                ],
                                "order_by" => [
                                    [
                                        "field" => "created_at",
                                        "direction" => "desc"
                                    ]
                                ],
                                "limit" => 3,
                                "offset" => 0
                             ];
                    
                            $token = config('api_sms');
                    
                            $curl = curl_init();
                            
                            curl_setopt_array($curl, array(
                                CURLOPT_URL => "https://smsgateway.me/api/v4/message/search",
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_ENCODING => "",
                                CURLOPT_MAXREDIRS => 10,
                                CURLOPT_TIMEOUT => 30,
                                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                CURLOPT_CUSTOMREQUEST => "POST",
                                CURLOPT_POSTFIELDS =>json_encode($filters),
                            
                                CURLOPT_HTTPHEADER => array(
                                    "authorization: $token",
                                    "cache-control: no-cache"
                                ),
                            ));
                            //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                            $response = curl_exec($curl);
                            $err = curl_error($curl);
                            curl_close($curl);
                            if ($err) {
                                echo "cURL Error #:" . $err;
                            } else {
                    
                                $data = json_decode($response, true);
                                $items = $data['results'];
                                $counts = $data['count'];
    
                                // Insert into transfer table
                                $trf = new Transfers();
                                $trf['bank'] = 'telkomsel';
                                $trf['total'] = $nominalpulsa;
                                $trf['data'] = $item['message'];
                                $trf['date'] = date('Y-m-d');
                                $trf['time'] = date('H:i:s');
                                $trf->save();
    
                                if ($counts != '0') {
                                    // Set trx diproses
                                    $updatetrx = Transactions::where('status', '0')
                                        ->where('payment_channel_id', '12')
                                        ->where('total', $nominalpulsa)
                                        ->where('payment_ref', $pengirimpulsa)
                                        ->update(['status' => '1']);
    
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
                                    $notif['message'] = 'Transaksi: ID #'.$datatrx->trx_id.' ('.$datatrx->product_code.') pembayaran sukses divalidasi via Transfer Pulsa, silahkan diproses...';
                                    $pusher->trigger('notifikasi', 'App\\Events\\Notify', $notif);
    
                                    // Notifikasi Email Admin:
                                    $datanotif = [
                                        'trx_id'    => $datatrx->trx_id,
                                        'code'      => $datatrx->product_code,
                                        'timetrx'   => $datatrx->created_at,
                                        'subject'   => 'Transaksi Divalidasi: #'.$datatrx->trx_id
                                    ];
                                    Mail::send('mail', $datanotif, function($message) use ($datanotif)
                                    {
                                        $message->from('cs@midasbuy.id','CS MIDASBUY');
                                        $message->to('cs@midasbuy.id','CS MIDASBUY');
                                        $message->subject($datanotif['subject']);
                                    });
                                }
    
                            }
                            
                        }
                        // Jika ditemukan transaksi Transfer Pulsa END
                    }
                    
                }
            }

        }
    }

}