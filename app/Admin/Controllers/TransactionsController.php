<?php

namespace App\Admin\Controllers;

use App\Transactions;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\SetSukses;

class TransactionsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Transactions';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Transactions());
        $grid->model()->orderBy('id', 'desc');

        $grid->column('trx_id', __('ID'))->display (function () {
            $linkstatus = '/order/'.$this->trx_id;
            return '<a href='.$linkstatus.' target="_blank">#' . $this->trx_id.'</a>';
        });
        $grid->column('created_at', __('Date'));
        $grid->User()->userid('User')->display (function ($userid) {
            return strtoupper($userid);
        });
        $grid->Items()->name('Item')->display (function ($name) {
            return $name;
        });
        $grid->column('product_code', __('Code'));
        $grid->column('game_id', __('ID Game'));
        $grid->column('phone', __('Phone / Email'))->display (function () {
            return $this->phone.'<br>'.$this->email;
        });
        $grid->column('phone', 'Phone')->setAttributes(['style' => 'display:none;']); // hide
        $grid->column('email', 'Email')->setAttributes(['style' => 'display:none;']); // hide
        $grid->column('total', __('Total'))->display (function () {
            return 'Rp ' . number_format($this->total, 0);
        });
        $grid->PaymentChannels()->payment_name('Payment')->display (function ($payment_name) {
            if ($this->payment_channel_id == NULL) {
                $payment_name = 'SALDO';
            }
            return strtoupper($payment_name);
        });
        // 0 => Waiting; 1 => Process, 2 => Success, 3 => Failed, 4 => Expired
        $grid->column('status')->using([
            0 => 'WAITING',
            1 => 'PROCESS',
            2 => 'SUCCESS',
            3 => 'FAILED',
            4 => 'EXPIRED',
            5 => 'API PROCESS',
        ], 'Unknown')->dot([
            0 => 'warning',
            1 => 'info',
            2 => 'success',
            3 => 'danger',
            4 => 'default',
            5 => 'info',
        ], 'warning');

        $grid->column('status1', __('Status'))->display (function () {
            if ($this->status == 0) {
                $textstatus = 'WAITING';
            }elseif ($this->status == 1) {
                $textstatus = 'PROCESS';
            }elseif ($this->status == 2) {
                $textstatus = 'SUCCESS';
            }elseif ($this->status == 3) {
                $textstatus = 'FAILED';
            }elseif ($this->status == 4) {
                $textstatus = 'EXPIRED';
            } else {
                $textstatus = 'API PROCESS';
            }
            return $textstatus;
        })->setAttributes(['style' => 'display:none;']); // hide

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->add(new SetSukses());
        });

        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableCreateButton();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('trx_id', 'ID #');
            $filter->like('product_code', 'Code');
            $filter->like('game_id', 'ID Game');
            $filter->like('phone', 'Phone');
            $filter->like('email', 'Email');
            $filter->like('total', 'Total');
            $filter->equal('user_id', 'User')->select(\App\User::all()->sortBy('userid')->pluck('userid', 'id'));
            $filter->equal('payment_channel_id', 'Payment')->select(['0' => 'SALDO', '1' => 'GOPAY', '2' => 'OVO', '5' => 'ALFAMART', '6' => 'INDOMARET', '8' => 'BCA', '9' => 'MANDIRI', '10' => 'BNI', '11' => 'BRI', '12' => 'TELKOMSEL']);
            $filter->equal('status')->select(['0' => 'WAITING', '1' => 'PROCESS', '2' => 'SUCCESS', '3' => 'FAILED', '4' => 'EXPIRED', '5' => 'API PROCESS']);
        });

        $grid->export(function ($export) {
            $export->filename('Data');
            $export->except(['photo', 'status']);
            $export->originalValue(['trx_id', 'created_at', 'product_code', 'game_id', 'phone', 'email', 'total', 'payment_channel_id']);
        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Transactions::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Transactions());

        $form->text('trx_id', __('ID #'))->required()->readonly();
        $form->text('created_at', __('Created'))->readonly();
        $form->text('updated_at', __('Updated'))->readonly();
        $form->select('user_id', 'User')->options(
            \App\User::get()->pluck('userid', 'id')
        )->readonly();
        $form->select('product_id', 'Item Product')->options(
            \App\Items::get()->pluck('name', 'id')
        )->required();
        $form->text('game_id', __('ID Game'));
        $form->text('phone', __('Phone'));
        $form->email('email', __('Email'));
        $form->currency('total', 'Total')->symbol('Rp')->digits(0)->required();
        $form->select('payment_channel_id', 'Payment')->options(
            \App\PaymentChannels::get()->pluck('payment_name', 'id')
        )->required();
        $form->select('status', 'Status')->options([0 => 'WAITING', 1 => 'PROCCESS',  2 => 'SUCCESS', 3 => 'FAILED', 4 => 'EXPIRED', 5 => 'API PROCCESS'])->default('0')->required();
        $form->text('payment_ref','Payment Ref')->readonly();
        $form->text('notes','API ID #')->readonly();

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}