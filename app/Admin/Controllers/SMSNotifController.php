<?php

namespace App\Admin\Controllers;

use App\SMSNotif;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Facades\Yugo\SMSGateway\Interfaces\SMS;
//use App\Admin\Actions\CekSMS;

class SMSNotifController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'SMS';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SMSNotif());
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('#'));
        $grid->column('type', __('Type'))->display (function () {
            if ($this->type == 'Inbox') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #5cb85c; color:#fff;">'.strtoupper($this->type).'</div>';
            } elseif ($this->type == 'Outbox') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #1087dd; color:#fff;">'.strtoupper($this->type).'</div>';
            }
        });
        $grid->column('sms_id', __('SMS ID'));
        $grid->column('phone_number', __('Phone'));
        $grid->column('message', __('Message'));
        $grid->column('status', __('Status'));
        $grid->column('created_at', __('Date'));

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
            //$actions->add(new CekSMS());
        });

        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('sms_id', 'SMS ID');
            $filter->like('phone_number', 'Phone');
            $filter->like('message', 'Message');
            $filter->equal('status')->select(['pending' => 'pending', 'sent' => 'sent', 'received' => 'received']);
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
        $show = new Show(SMSNotif::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new SMSNotif());

        $form->text('device_id', __('Device iD'))->default('118444')->readonly()->required();
        //$form->select('type', 'Type')->options(['Inbox' => 'Inbox', 'Outbox' => 'Outbox'])->default('Outbox')->readonly()->required();
        $form->hidden('type', __('Type'));
        $form->hidden('sms_id', __('SMS ID'));
        $form->text('phone_number', __('Phone Number'))->required();
        $form->textarea('message', __('Message'))->rows(3)->required();
        //$form->select('status', 'Status')->options(['pending' => 'pending', 'sent' => 'sent', 'canceled' => 'canceled'])->default('pending')->required();
        $form->hidden('status', __('Status'));

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

        $form->saving(function (Form $form) {
            $d = SMS::send([$form->phone_number], $form->message);
            $sms_id = $d['data'][0]->id;
            $form->sms_id = $sms_id;
            $form->type = 'Outbox';
            $form->status = 'pending';
        });

        return $form;
    }
}