<?php

namespace App\Admin\Controllers;

use App\Products;
use App\Items;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ItemsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Items';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Items());
        $grid->model()->orderBy('product_id', 'desc')->orderBy('nominal', 'asc');

        $grid->Products()->name('Product')->display (function ($product_id) {
            return $product_id;
        });
        $grid->column('name', __('Item Name'));
        $grid->column('code', __('Code'));
        $grid->column('nominal', __('Nominal'));
        $grid->column('price_reguler', __('Price Regular'))->display (function () {
            return 'Rp ' . number_format($this->price_reguler, 0);
        });
        $grid->column('price_reseller', __('Price Reseller'))->display (function () {
            return 'Rp ' . number_format($this->price_reseller, 0);
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
        
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->equal('product_id', 'Product')->select(\App\Products::all()->sortBy('id')->pluck('name', 'id'));
            $filter->like('name', 'Item Name');
            $filter->like('code', 'Code');
            $filter->equal('status')->select(['1' => 'ACTIVE', '0' => 'INACTIVE']);
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
        $show = new Show(Items::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Items());

        $form->select('product_id', 'Product')->options(
            \App\Products::get()->pluck('name', 'id')
        )->required();
        $form->text('name', __('Item Name'))->required();
        $form->text('code', __('Code'))->required();
        $form->number('nominal', __('Nominal'))->required();
        $form->currency('price_reguler', 'Price Regular')->symbol('Rp')->digits(0)->required();
        $form->currency('price_reseller', 'Price Reseller')->symbol('Rp')->digits(0)->required();

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