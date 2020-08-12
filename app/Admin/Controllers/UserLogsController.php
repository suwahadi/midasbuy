<?php

namespace App\Admin\Controllers;

use App\UserLogs;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class UserLogsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'User Logs';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserLogs());
        $grid->model()->orderBy('id', 'desc');

        $grid->column('id', __('#'));
        $grid->User()->userid('User')->display (function ($userid) {
            return strtoupper($userid);
        });
        $grid->column('total', __('Total'))->display (function () {
            return 'Rp ' . number_format($this->total, 0);
        });
        $grid->column('type', __('Type'));
        $grid->column('notes', __('Notes'));
        $grid->column('balance', __('Balance'))->display (function () {
            return 'Rp ' . number_format($this->balance, 0);
        });
        $grid->column('created_at', 'Date');

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
        });

        $grid->disableCreateButton();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('userid', 'User')->select(\App\User::all()->sortBy('userid')->pluck('userid', 'id'));
            $filter->like('total', 'Total');
            $filter->equal('type')->select(['Credit' => 'Credit', 'Debet' => 'Debet']);
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
        $show = new Show(UserLogs::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserLogs());

        $form->select('userid', 'User')->options(
            \App\User::get()->pluck('userid', 'id')
        )->required();
        $form->currency('total', 'Total')->symbol('Rp')->digits(0)->required();
        $form->select('type', 'Type')->options(['Credit' => 'Credit', 'Debet' => 'Debet'])->required();
        $form->text('notes', __('Notes'));
        $form->currency('balance', 'Balance')->symbol('Rp')->digits(0)->readonly();

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