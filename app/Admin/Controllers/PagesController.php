<?php

namespace App\Admin\Controllers;

use App\Pages;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class PagesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Pages';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Pages());

        $grid->column('titlePage', __('Title'));
        $grid->column('slugPage', __('Slug'));
        $grid->column('contentPage', 'Content')->display (function () {
            return str_limit(strip_tags($this->contentPage), 350, '...');
        });
        $grid->column('status')->using([
            0 => 'INACTIVE',
            1 => 'ACTIVE',
        ], 'Unknown')->dot([
            0 => 'danger',
            1 => 'success',
        ], 'warning');

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->disableFilter();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();

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
        $show = new Show(Pages::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Pages());

        $form->text('titlePage', __('Title'))->required();
        $form->text('slugPage', __('Slug'))->required();
        $form->ckeditor('contentPage','Content');
        $form->select('status', 'Status')->options([0 => 'INACTIVE', 1 => 'ACTIVE'])->default('1')->required();

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