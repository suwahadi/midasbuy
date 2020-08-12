<?php

namespace App\Admin\Controllers;

use App\User;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\Hash;

class UsersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User Manager';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new User());

        $grid->column('userid', __('User ID'));
        $grid->column('name', __('Name'));
        $grid->column('email', __('Email'));
        $grid->column('phone', __('Phone'));
        $grid->column('balance', __('Balance'))->display (function () {
            return 'Rp ' . number_format($this->balance, 0);
        });
        $grid->column('type', 'Type')->using([
            0 => 'REGULAR',
            1 => 'RESELLER',
        ], 'Unknown')->dot([
            0 => 'warning',
            1 => 'success',
        ], 'warning');
        $grid->column('status')->using([
            1 => 'ACTIVE',
            2 => 'BLOCKED',
        ], 'Unknown')->dot([
            1 => 'success',
            2 => 'danger',
        ], 'warning');
        $grid->column('email_verified_at', __('Verified'));

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('userid', 'User ID');
            $filter->like('name', 'Name');
            $filter->like('email', 'Email');
            $filter->like('phone', 'Phone');
            $filter->equal('type', 'Type')->select(['0' => 'REGULAR', '1' => 'RESELLER']);
            $filter->equal('status')->select(['1' => 'ACTIVE', '2' => 'BLOCKED']);
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
        $show = new Show(User::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new User());

        $form->text('userid', __('User ID'))->readonly();
        $form->text('name', __('Name'))->required();
        $form->email('email', __('Email'))->required();
        $form->text('phone', __('Phone'))->required();
        $form->password('password', 'Password')->rules('required')->help('Biarkan kolom password jika tidak ingin ubah password');
        $form->text('api_key', __('Api Key'));
        $form->select('type', 'Member Type')->options([0 => 'REGULAR', 1 => 'RESELLER'])->default('0')->required();
        $form->currency('balance', 'Balance')->symbol('Rp')->digits(0);
        $form->select('status', 'Status')->options([1 => 'ACTIVE', 2 => 'BLOCKED'])->default('1')->required();
        $form->datetime('email_verified_at', __('Verified at'));

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
            if ($form->password && $form->model()->password != $form->password) {
                $form->password = Hash::make($form->password);
            }
        });

        return $form;
    }
}
