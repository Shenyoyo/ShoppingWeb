<?php

namespace App\Admin\Controllers;

use App\Product;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Product';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->column('id', __('Id'));
        $grid->column('name', __('shop.Product Name'));
        $grid->column('description', __('Description'));
        $grid->column('price', __('shop.price'));
        $grid->column('amount', __('shop.Stock Quantity'));
        $grid->column('buy_yn', __('shop.Category'));
        $grid->column('display_yn', __('shop.Product Dispaly'));
        $grid->column('file_id', __('File id'));
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));
        

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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('price', __('Price'));
        $show->field('amount', __('Amount'));
        $show->field('buy_yn', __('Buy yn'));
        $show->field('display_yn', __('Display yn'));
        $show->field('file_id', __('File id'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));
       

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Product());

        $form->text('name', __('Name'));
        $form->text('description', __('Description'));
        $form->decimal('price', __('Price'));
        $form->number('amount', __('Amount'));
        $form->text('buy_yn', __('Buy yn'));
        $form->text('display_yn', __('Display yn'));
        $form->text('file_id', __('File id'));
        

        return $form;
    }
}
