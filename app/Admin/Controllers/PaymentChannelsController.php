<?php

namespace App\Admin\Controllers;

use App\PaymentChannels;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PaymentChannelsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Payment Channels';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new PaymentChannels());
        $grid->model()->orderBy('id', 'asc');
        $grid->model()->where('status', '=', 1);

        // $grid->column('id', __('#'));
        $grid->column('payment_name', __('Name'));
        $grid->column('payment_code', __('Code'))->upper();
        $grid->payment_logo('Logo')->image('/storage/', 100, 100);
        $grid->column('payment_description', __('Description'));
        $grid->column('mark_up_price', __('Mark Up (+)'));
        // $grid->column('status')->using([
        //     0 => 'INACTIVE',
        //     1 => 'ACTIVE',
        // ], 'Unknown')->dot([
        //     0 => 'danger',
        //     1 => 'success',
        // ], 'warning');

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });

        $grid->disableFilter();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();
        $grid->disableCreateButton();

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
        $show = new Show(PaymentChannels::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PaymentChannels());

        $form->text('payment_name', __('Payment Name'))->required();
        $form->text('payment_code', __('Payment Code'))->rules('required|max:3');
        $form->image('payment_logo', 'Logo')->uniqueName()->required();
        $form->text('payment_description', __('Description'))->required();
        $form->text('api_key', __('Nomor Rekening'));
        $form->text('api_user', __('Atas Nama'));
        $form->number('mark_up_price', 'Mark Up (+)')->required();
        // $form->select('status', 'Status')->options([0 => 'INACTIVE', 1 => 'ACTIVE'])->default('1')->required();

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