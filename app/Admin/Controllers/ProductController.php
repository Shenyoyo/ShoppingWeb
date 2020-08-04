<?php

namespace App\Admin\Controllers;

use App\Product;
use App\File;
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

        $grid->column('id', __('shop.ID'));
        $grid->column('name', __('shop.Product Name'));
        $grid->column('price', __('shop.price'))->display(function ($price) {
            return presentPrice($price);
        });;
        $grid->column('amount', __('shop.Stock Quantity'));
        $grid->column('buy_yn', __('shop.Product Buy'))->bool(['Y' => true, 'N' => false]);;
        $grid->column('display_yn', __('shop.Product Dispaly'))->bool(['Y' => true, 'N' => false]);;
        $grid->column('image',__('Image'));
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
        $show->field('image',__('Image'));
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

        $form->text('name', __('Name'))->rules('required');
        $form->text('description', __('Description'))->rules('required');
        $form->text('price', __('Price'))->rules('required|integer|digits_between:1,11');
        $form->number('amount', __('Amount'))->rules('required');
        $form->radio('buy_yn',__('Buy yn') )->options(['Y' => '是' , 'N' => '否'])->default('Y');
        $form->radio('display_yn', __('Display yn'))->options(['Y' => '是' , 'N' => '否'])->default('Y');;
        $form->image('image', __('image'));
 
        return $form;
    }
}
