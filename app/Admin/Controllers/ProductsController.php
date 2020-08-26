<?php

namespace App\Admin\Controllers;

use App\Products;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Products';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Products());
        $grid->model()->orderBy('id', 'desc');

        $grid->thumbnail('Thumbnail')->image('/storage/', 100, 100);
        $grid->column('name', __('Name'));
        $grid->column('slug', __('Slug'));
        $grid->column('denom', __('Denom'));
        // $grid->column('intro', 'Intro')->display (function () {
        //     return str_limit(strip_tags($this->intro), 145, '...');
        // });
        $grid->column('description', 'Description')->display (function () {
            return str_limit(strip_tags($this->description), 420, '...');
        });
        // $grid->column('promo')->using([
        //     'Yes' => 'YES',
        //     'No' => 'NO',
        // ], 'Unknown')->dot([
        //     'Yes' => 'success',
        //     'No' => 'default',
        // ], 'warning');
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
        $show = new Show(Products::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Products());

        $form->image('thumbnail', 'Thumbnail')->uniqueName()->required();
        $form->text('name', __('Name'));
        $form->text('slug', __('Slug'));
        $form->text('denom', __('Denom'));
        $form->image('image', __('Image'))->uniqueName()->required();
        // $form->textarea('intro', __('Intro'));
        $form->text('ios_link', __('iOS Download'));
        $form->text('android_link', __('Android Download'));
        $form->ckeditor('description','Description');
        // $form->select('promo', 'Promo')->options(['No' => 'NO', 'Yes' => 'YES'])->default('No')->required();
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