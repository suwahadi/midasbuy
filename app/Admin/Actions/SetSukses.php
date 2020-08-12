<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\Transactions;
use App\PaymentChannels;
use App\User;
use App\Items;
use Illuminate\Support\Facades\Mail;

class SetSukses extends RowAction
{
    public $name = '&#10004; Set Success';

	public function handle(Model $model)
    {
    	$modelstatus = $model->status;
    	
    	$Data = Transactions::find($model->id);
		$Data->status = '2';
		$Data->save();

		if ($model->payment_channel_id == '0') {
			$PaymentName = 'Saldo Member';
		} else {
			$PaymentChannels = PaymentChannels::where('id', $model->payment_channel_id)->first();
			$PaymentName = $PaymentChannels->payment_name;
		}

		if ($model->user_id != '') {
			$User = User::where('id', $model->user_id)->first();
			$NamaUser = $User->name;
		} else {
			$NamaUser = 'Kak';
		}

		$Item = Items::where('code', $model->product_code)->first();
		$ItemName = $Item->name;

		// Notifikasi Email User:
		$datanotif = [
			'trx_id'    => $model->trx_id,
			'timetrx'   => $model->created_at,
			'item_code' => $model->product_code,
			'item_name'	=> $ItemName,
			'game_id' 	=> $model->game_id,
			'total' 	=> $model->total,
			'payment' 	=> $PaymentName,
			'email'   	=> $model->email,
			'phone'   	=> $model->phone,
			'namauser'	=> $NamaUser,
			'subject'   => 'Terima kasih atas order Anda #'.$model->trx_id
		];

		Mail::send('mail-trxuser', $datanotif, function($message) use ($datanotif)
		{
			$message->from('cs@midasbuy.id','CS MIDASBUY');
			$message->to($datanotif['email']);
			$message->subject($datanotif['subject']);
		});
		
		// Notifikasi SMS User:
			$array_fields['phone_number'] = $model->phone;
			$array_fields['message'] = 'Selamat! Pesanan: #'.$model->trx_id.' di MIDASBUY.ID sudah sukses, detail orderan cek Email Anda.';
			$array_fields['device_id'] = config('device_id_sms');
	
			$APISMS = config('api_sms');
	
			$curl = curl_init();
	
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://smsgateway.me/api/v4/message/send",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 30,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => "POST",
				CURLOPT_POSTFIELDS => "[  " . json_encode($array_fields) . "]",
				CURLOPT_HTTPHEADER => array(
					"authorization: $APISMS",
					"cache-control: no-cache"
				),
			));
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	
			$response = curl_exec($curl);
			$err = curl_error($curl);
	
			curl_close($curl);
	
			if ($err) {
				echo "cURL Error #: " . $err;
			}

        return $this->response()->success('Email & SMS berhasil dikirimkan...')->refresh();
    }

}