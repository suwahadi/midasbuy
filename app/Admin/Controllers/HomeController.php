<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets;

class HomeController extends Controller
{

    public function index(Content $content)
    {

        $content->title('Dashboard');
        $content->description(' ');

        $content->row(function ($row) {
            $TotalProducts = \App\Products::get()->count();
            $TotalItems = \App\Items::get()->count();
            $TotalTransactionsSuccess = \App\Transactions::get()->count();
            $TotalUsers = \App\User::get()->count();

            $row->column(3, new Widgets\InfoBox('Total Products', 'gift', 'purple', 'admin/products', $TotalProducts));
            $row->column(3, new Widgets\InfoBox('Total Items', 'tags', 'primary', 'admin/items', $TotalItems));
            $row->column(3, new Widgets\InfoBox('Total Transactions', 'shopping-cart', 'teal', 'admin/transactions', $TotalTransactionsSuccess));
            $row->column(3, new Widgets\InfoBox('Total Users', 'users', 'gray', 'admin/users', $TotalUsers));
        });

        $content->row(function ($row) {
            $TotalDeposits = \App\Deposit::get()->where('status', '1')->sum('total');
            $TotalTansfers = \App\Transfers::get()->sum('total');
            $SuccessTransactionsRp = \App\Transactions::get()->where('status', '2')->sum('total');
            $PendingTransactionsRp = \App\Transactions::get()->where('status', '1')->sum('total');

            $row->column(3, new Widgets\InfoBox('Deposit Success', 'money', 'aqua', 'admin/deposit', 'Rp '.number_format($TotalDeposits, 0)));
            $row->column(3, new Widgets\InfoBox('Bank Transfers', 'bank', 'blue', 'admin/bank', 'Rp '.number_format($TotalTansfers, 0)));
            $row->column(3, new Widgets\InfoBox('Transactions Success', 'bar-chart', 'green', 'admin/transactions', 'Rp '.number_format($SuccessTransactionsRp, 0)));
            $row->column(3, new Widgets\InfoBox('Transactions Pending', 'history', 'yellow', 'admin/transactions', 'Rp '.number_format($PendingTransactionsRp, 0)));
        });
        
        return $content;

    }

}