<?php

namespace App\Admin\Controllers;

use App\Transfers;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TransfersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Mutasi Bank';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Transfers());
        $grid->model()->orderBy('id', 'desc');

        $grid->column('bank', __('Bank'))->display (function () {
            if ($this->bank == 'bca') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #003766; color:#fff;">'.strtoupper($this->bank).'</div>';
            } elseif ($this->bank == 'mandiri') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #3373aa; color:#fff;">'.strtoupper($this->bank).'</div>';
            } elseif ($this->bank == 'bni') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #e55300; color:#fff;">'.strtoupper($this->bank).'</div>';
            } elseif ($this->bank == 'bri') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #004285; color:#fff;">'.strtoupper($this->bank).'</div>';
            } elseif ($this->bank == 'ovo') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #605ca8; color:#fff;">'.strtoupper($this->bank).'</div>';
            } elseif ($this->bank == 'gopay') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #00AED6; color:#fff;">'.strtoupper($this->bank).'</div>';
            } elseif ($this->bank == 'telkomsel') {
                return '<div style="width:65px; text-align: center; padding: 3px; background: #ED1B24; color:#fff;">'.strtoupper('PULSA').'</div>';
            }
        });
        $grid->column('total', __('Amount'))->display (function () {
            return 'Rp ' . number_format($this->total, 0);
        });
        $grid->column('data', __('Data'));
        $grid->column('date', __('Date'));
        $grid->column('time', __('Time'));
        $grid->column('created_at', __('Created at'));

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
            $filter->equal('bank', 'Bank')->select(['bca' => 'BCA', 'mandiri' => 'MANDIRI', 'bni' => 'BNI', 'bri' => 'BRI', 'gopay' => 'GOPAY', 'ovo' => 'OVO', 'telkomsel' => 'PULSA']);
            $filter->like('total', 'Amount');
            $filter->like('data', 'Data');
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
        $show = new Show(Transfers::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Transfers());

        $form->select('bank', 'Bank')->options(['bca' => 'BCA', 'mandiri' => 'MANDIRI', 'bni' => 'BNI', 'bri' => 'BRI'])->required();
        $form->currency('total', 'Amount')->symbol('Rp')->digits(0)->required();
        $form->textarea('data', __('Data'))->rows(1)->required();
        $form->date('date', __('Date'))->default(date('Y-m-d'))->required();
        $form->time('time', __('Time'))->default(date('H:i:s'))->required();

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