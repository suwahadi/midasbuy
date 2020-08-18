<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Items;
use App\PaymentChannels;
use App\Transactions;

class ProductsController extends Controller
{

    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }


    // GET PRODUCT BY SLUG
    public function getProductByCode($productSlug)
    {
        $product = DB::table('products')->where([
            ['slug', '=', $productSlug],
            ['status', '=', '1']
        ])->first();
        return $product;
    }


    // GET ALL PRODUCT LIST
    public function getAllProduct()
    {
        $product = DB::table('items')->get();
        return $product;
    }


    public function getDetail($productSlug)
    {
        $productByCode = $this->getProductByCode($productSlug);
        
        if ($productByCode == NULL) {
            return redirect()->route('frontpage');
        } else {
            $productID = $productByCode->id;
        }

        $productList = DB::table('items')->orderBy('nominal', 'asc')->where([
            ['product_id', '=', $productID],
            ['status', '=', '1']
        ])->get();

        $payments = DB::table('payment_channels')->where([
            ['status', '=', '1']
        ])->get();

        $ovo = DB::table('payment_channels')->where([
            ['payment_code', 'OVO']
        ])->first();
        $gopay = DB::table('payment_channels')->where([
            ['payment_code', 'GPY']
        ])->first();
        $indomaret = DB::table('payment_channels')->where([
            ['payment_code', 'IND']
        ])->first();
        $alfamart = DB::table('payment_channels')->where([
            ['payment_code', 'ALF']
        ])->first();
        $bca = DB::table('payment_channels')->where([
            ['payment_code', 'BCA']
        ])->first();
        $mandiri = DB::table('payment_channels')->where([
            ['payment_code', 'MDR']
        ])->first();
        $bni = DB::table('payment_channels')->where([
            ['payment_code', 'BNI']
        ])->first();
        $bri = DB::table('payment_channels')->where([
            ['payment_code', 'BRI']
        ])->first();
        $telkomsel = DB::table('payment_channels')->where([
            ['payment_code', 'TSL']
        ])->first();

        $payment_name = DB::table('payment_channels')->pluck('payment_name');
        $payment_code = DB::table('payment_channels')->pluck('payment_code');

        $produkpluck = DB::table('items')->orderBy('nominal', 'asc')->where('product_id', $productID)->get();

        if ($productByCode) {
            $markovo = $ovo->mark_up_price;
            $markgopay = $gopay->mark_up_price;
            $markindomaret = $indomaret->mark_up_price;
            $markalfamart = $alfamart->mark_up_price;
            $markbca = $bca->mark_up_price;
            $markmandiri = $mandiri->mark_up_price;
            $markbni = $bni->mark_up_price;
            $markbri = $bri->mark_up_price;
            $marktelkomsel = $telkomsel->mark_up_price/100;
            return view('product', [
                'productByCode'     => $productByCode,
                'productList'       => $productList,
                'payments'          => $payments,
                'payment_name'      => $payment_name,
                'payment_code'      => $payment_code,
                'produkpluck'       => $produkpluck,
                'ovo'               => $ovo,
                'gopay'             => $gopay,
                'indomaret'         => $indomaret,
                'alfamart'          => $alfamart,
                'bca'               => $bca,
                'mandiri'           => $mandiri,
                'bni'               => $bni,
                'bri'               => $bri,
                'telkomsel'         => $telkomsel,
                'markovo'           => $markovo,
                'markgopay'         => $markgopay,
                'markindomaret'     => $markindomaret,
                'markalfamart'      => $markalfamart,
                'markbca'           => $markbca,
                'markmandiri'       => $markmandiri,
                'markbni'           => $markbni,
                'markbri'           => $markbri,
                'marktelkomsel'     => $marktelkomsel,
            ]);
        } else {
            return redirect()->route('frontpage');
        }
    }


    public function get_by_item (Request $request)
    {
        $ovo = DB::table('payment_channels')->where([
            ['payment_code', 'OVO']
        ])->first();
        $gopay = DB::table('payment_channels')->where([
            ['payment_code', 'GPY']
        ])->first();
        $indomaret = DB::table('payment_channels')->where([
            ['payment_code', 'IND']
        ])->first();
        $alfamart = DB::table('payment_channels')->where([
            ['payment_code', 'ALF']
        ])->first();
        $bca = DB::table('payment_channels')->where([
            ['payment_code', 'BCA']
        ])->first();
        $mandiri = DB::table('payment_channels')->where([
            ['payment_code', 'MDR']
        ])->first();
        $bni = DB::table('payment_channels')->where([
            ['payment_code', 'BNI']
        ])->first();
        $bri = DB::table('payment_channels')->where([
            ['payment_code', 'BRI']
        ])->first();
        $telkomsel = DB::table('payment_channels')->where([
            ['payment_code', 'TSL']
        ])->first();
        $markovo = $ovo->mark_up_price;
        $markgopay = $gopay->mark_up_price;
        $markindomaret = $indomaret->mark_up_price;
        $markalfamart = $alfamart->mark_up_price;
        $markbca = $bca->mark_up_price;
        $markmandiri = $mandiri->mark_up_price;
        $markbni = $bni->mark_up_price;
        $markbri = $bri->mark_up_price;
        $marktelkomsel = $telkomsel->mark_up_price/100;

        if (!$request->id) {
            $html = '';
        } else {
            $html = '';
            $prd = Items::where('id', $request->id)->first();

            if (auth()->user()) {
                if (auth()->user()->type == 1) {
                    $price = $prd->price_reseller;
                } else {
                    $price = $prd->price_reguler;
                }
            } else {
                $price = $prd->price_reguler;
            }
                $memberr = 'Harga:<br>Rp '.number_format($price, 0);
                $input0 = $price;
                $ovo = 'Rp '.(number_format($price+$markovo, 0));
                $input1 = ($price+$markovo);
                $indomaret = 'Rp '.(number_format($price+$markindomaret, 0));
                $input2 = ($price+$markindomaret);
                $alfamart = 'Rp '.(number_format($price+$markalfamart, 0));
                $input3 = ($price+$markalfamart);
                $bca = 'Rp '.(number_format($price+$markbca, 0));
                $input4 = ($price+$markbca);
                $mandiri = 'Rp '.(number_format($price+$markmandiri, 0));
                $input5 = ($price+$markmandiri);
                $bni = 'Rp '.(number_format($price+$markbni, 0));
                $input6 = ($price+$markbni);
                $bri = 'Rp '.(number_format($price+$markbri, 0));
                $input7 = ($price+$markbri);
                $gopay = 'Rp '.(number_format($price+$markgopay, 0));
                $input8 = ($price+$markgopay);

                $total = $price+($price*$marktelkomsel);
                $ratusan = substr($total, -3);
                if($ratusan<200) {
                    $akhir = $total - $ratusan;
                } else {
                    $akhir = $total + (1000-$ratusan);
                }
                $telkomsel = 'Rp '. number_format($akhir, 0);
                $input9 = $akhir;

                $productCode = $prd->code;
        }
        return response()->json(['memberr' => $memberr, 'ovo' => $ovo, 'gopay' => $gopay, 'indomaret' => $indomaret, 'alfamart' => $alfamart, 'bca' => $bca, 'mandiri' => $mandiri, 'bni' => $bni, 'bri' => $bri, 'telkomsel' => $telkomsel, 'input0' => $input0, 'input1' => $input1, 'input2' => $input2, 'input3' => $input3, 'input4' => $input4, 'input5' => $input5, 'input6' => $input6, 'input7' => $input7, 'input8' => $input8, 'input9' => $input9, 'productCode' => $productCode]);
    }

    public function TansferPulsa (Request $request) {
        // START cek prefix Telkomsel
        $re = '/(62811|62812|62813|62821|62822|62823|62851|62852|62853)\d{7,9}/m';
        $str = $request->phone;
        if (preg_match_all($re, $str, $matches, PREG_SET_ORDER, 0)) {
            $request->phone = $matches[0][0];
            $trxupd = Transactions::where('trx_id', $request->trx_id)
            ->where('status', '0')
            ->where('payment_channel_id', '12')
            ->update(['payment_ref' => $request->phone, 'notes' => $request->trx_id]);
            return redirect('transferpulsa/'.$request->trx_id);
        }else{
            return redirect()->back()->with('errorNomor','Pastikan nomor Telkomsel yang Anda masukkan sudah benar, awalan harus 62, tanpa tanda hubung / tanpa spasi (Contoh: 6281234567890)');
        }
        // END cek prefix Telkomsel
    }


    public function DetailTansferPulsa ($trx_id) {
        $transaction = Transactions::where('trx_id', $trx_id)
            ->where('status', '0')
            ->where('payment_channel_id', '12')
            ->first();
        
        if ($transaction) {
        $payment = PaymentChannels::where('id', $transaction->payment_channel_id)
            ->first();
        } else {
            return redirect()->route('frontpage');
        }

        if ($transaction) {
            return view('transferpulsa', [
                'transaction' => $transaction,
                // 'product' => $product,
                'payment' => $payment,
            ]);
        } else {
            return redirect()->route('frontpage');
        }
    }

}