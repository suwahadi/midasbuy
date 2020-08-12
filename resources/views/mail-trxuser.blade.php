<p>
Halo {{$namauser}},<br>
Terima kasih atas order Anda di <a href="{{url('/')}}">{{config('webname')}}</a>.<br>
<br>
<strong>DETAIL PESANAN</strong><br>
Order ID: #{{$trx_id}}<br>
Tanggal: {{$timetrx}}<br>
Nomor HP: {{$phone}}<br>
Email: {{$email}}<br>
Item Code: {{$item_code}}<br>
Item Name: {{$item_name}}<br>
ID Game: {{$game_id}}<br>
<br>
<strong>DETAIL PEMBAYARAN</strong><br>
Total Pembayaran: Rp {{number_format($total, 0)}}<br>
Bayar Pakai: {{$payment}}<br>
Status: Sukses
<br>
<br>
Selamat main game...!<br>
</p>