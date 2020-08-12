<?php

namespace App\Admin\Controllers;

use App\Deposit;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DepositController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Deposit Manager';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Deposit());
        $grid->model()->orderBy('id', 'desc');
        
        $grid->column('id', __('ID'));
        $grid->column('created_at', __('Date'));
        $grid->User()->userid('User')->display (function ($userid) {
            return strtoupper($userid);
        });
        $grid->column('total', __('Amount'))->display (function () {
            return 'Rp ' . number_format($this->total, 0);
        });
        $grid->PaymentChannels()->payment_name('Payment')->display (function ($payment_name) {
            return strtoupper($payment_name);
        });
        $grid->column('status')->using([
            0 => 'WAITING',
            1 => 'SUCCESS',
            2 => 'EXPIRED',
        ], 'Unknown')->dot([
            0 => 'warning',
            1 => 'success',
            2 => 'default',
        ], 'warning');
        $grid->column('updated_at', __('Updated'));

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('userid', 'User')->select(\App\User::all()->sortBy('userid')->pluck('userid', 'id'));
            $filter->like('total', 'Amount');
            $filter->equal('payment_channel', 'Payment')->select(['1' => 'GOPAY', '2' => 'OVO', '5' => 'ALFAMART', '6' => 'INDOMARET', '8' => 'BCA', '9' => 'MANDIRI', '10' => 'BNI', '11' => 'BRI', '12' => 'TELKOMSEL']);
            $filter->equal('status')->select(['0' => 'WAITING', '1' => 'SUCCESS','2' => 'EXPIRED']);
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
        $show = new Show(Deposit::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Deposit());
        $form->text('id', 'ID')->required()->readonly();
        $form->select('userid', 'User')->options(
            \App\User::get()->pluck('userid', 'id')
        )->required();
        $form->currency('total', 'Amount')->symbol('Rp')->digits(0)->required();
        $form->select('payment_channel', 'Payment Channel')->options(
            \App\PaymentChannels::get()->pluck('payment_name', 'id')
        )->required();
        $form->text('payment_ref', 'Payment Ref')->readonly();
        $form->select('status', 'Status')->options([0 => 'WAITING', 1 => 'SUCCESS', 2 => 'EXPIRED'])->default('0')->required();

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
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