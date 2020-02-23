<?php

namespace App\Admin\Controllers;

use App\Models\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use mysql_xdevapi\Exception;

class ProductsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '商品';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product);

        $grid->column('id', __('ID'))->sortable();
        $grid->column('title', __('商品名称'));
        $grid->column('on_sale', __('已上架'))->display(function ($value) {
            return $value ? '是' : '否';
        });
        $grid->column('price', __('价格'));
        $grid->column('rating', __('评分'));
        $grid->column('sold_count', __('销量'));
        $grid->column('review_count', __('评论数'));
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product);

        $form->text('title', __('商品名称'))->rules('required');
        $form->image('image', __('封面图片'))->rules('required|image');
        $form->quill('description', __('商品描述'))->rules('required');
        $form->switch('on_sale', __('上架'))->options(['1' => '是','2' => '否'])->default('0');

        // 一对多关联模型数据
        $form->hasMany('skus', 'SKU 列表', function (Form\NestedForm $form) {
            $form->text('title', __('SKU 名称'))->rules('required');
            $form->text('description', __('SKU 描述'))->rules('required');
            $form->text('price', __('单价'))->rules('required|numeric|min:0.01');
            $form->text('stock', __('剩余库存'))->rules('required|integer|min:0');
        });

        // 保存前回调
        $form->saving(function (Form $form) {
            $form->model()->price = collect($form->input('skus'))->where(Form::REMOVE_FLAG_NAME, 0)->min('price') ?: 0;
        });

        return $form;
    }
}
