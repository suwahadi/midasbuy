<?php

namespace App\Admin\Controllers;

use App\promoBannerSection;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Carbon;

class BannersController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Banners';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new promoBannerSection());

        $grid->srcUrl('Banner')->image('/storage/', 100, 100);
        $grid->column('altText', __('Title'));
        $grid->column('href', __('Link'));
        $grid->column('created_at', __('Created'));
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
        $show = new Show(promoBannerSection::findOrFail($id));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new promoBannerSection());

        $form->image('srcUrl', 'Banner')->uniqueName()->required();
        $form->text('altText', __('Title'))->required();
        $form->text('href', __('Link'))->required();
        $form->hidden('starttime', __('Start Time'))->required();
        $form->hidden('endtime', __('End Time'))->required();
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

        $form->saving(function (Form $form) {
            $datetime = now();
            $skrg = Carbon\Carbon::parse($datetime)->format('Y-m-d\TH:i:00.000\Z');
            $form->starttime = $skrg;
            
            if ($form->status != 1){
                $form->endtime = $skrg;
            } else {
                $form->endtime = '2050-01-01T01:01:00.000Z';
            }
        });

        return $form;

    }
}