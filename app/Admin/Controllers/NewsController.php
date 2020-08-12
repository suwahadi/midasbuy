<?php

namespace App\Admin\Controllers;

use App\News;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class NewsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'News';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News());
        $grid->model()->orderBy('id', 'desc');

        $grid->column('titleNews', __('Title'));
        $grid->column('slugNews', __('Slug'));
        $grid->thumbNews('Thumbnail')->image('/storage/', 100, 100);
        $grid->column('contentNews', 'Content')->display (function () {
            return str_limit(strip_tags($this->contentNews), 350, '...');
        });
        $grid->column('status')->using([
            0 => 'INACTIVE',
            1 => 'ACTIVE',
        ], 'Unknown')->dot([
            0 => 'danger',
            1 => 'success',
        ], 'warning');
        // $grid->column('created_at', __('Created at'));
        // $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(News::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new News());

        $form->text('titleNews', __('Title'))->required();
        $form->text('slugNews', __('Slug'))->required();
        $form->image('thumbNews', __('Thumbnail'))->uniqueName()->required();
        $form->ckeditor('contentNews','Content');
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