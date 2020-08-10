<?php

namespace App\Admin\Controllers;

use App\Product;
use App\File;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use App\Admin\Actions\Post\Restore;
use App\Admin\Actions\Post\BatchRestore;
use App\Category;

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
        $grid->column('category')->display(function ($category) {

            $category = array_map(function ($category) {
                return "<span class='label label-success'>{$category['name']}</span>";
            }, $category);
        
            return join('&nbsp;', $category);
        });
        $grid->column('price', __('shop.price'))->display(function ($price) {
            return presentPrice($price);
        });
        $grid->column('amount', __('shop.Stock Quantity'));
        $grid->column('buy_yn', __('shop.Product Buy'))->bool(['Y' => true, 'N' => false]);
        $grid->column('display_yn', __('shop.Product Dispaly'))->bool(['Y' => true, 'N' => false]);
        $grid->column('created_at', __('shop.Created at'));
        $grid->column('updated_at', __('shop.Updated at'));

      
         // 篩選器
        $grid->filter(function ($filter) {
            //軟刪除查詢調用模型的`onlyTrashed`方法，查詢出被軟刪除的數據。
            $filter->scope('trashed', '回收站')->onlyTrashed();
            //查詢商品名稱
            $filter->like('name', __('shop.Product Name'));
        });
        //單一恢復
        $grid->actions(function ($actions) {
            if (\request('_scope_') == 'trashed') {
                $actions->add(new Restore());
            }
        });
        //批次恢復
        $grid->batchActions(function ($batch) {
            if (\request('_scope_') == 'trashed') {
                $batch->add(new BatchRestore());
            }
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
        $show = new Show(Product::findOrFail($id));

        $show->field('id', __('shop.ID'));
        $show->field('name', __('shop.Product Name'));
        $show->field('description', __('shop.Description'));
        $show->field('price', __('shop.price'));
        $show->field('amount', __('shop.Stock Quantity'));
        $show->field('buy_yn', __('shop.Product Buy'));
        $show->field('display_yn', __('shop.Product Dispaly'));
        $show->field('image', __('Image'))->image();
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

        $form->text('name', __('shop.Product Name'))->rules('required|max:255');
        $form->checkboxCard('category',__('shop.Category'))->options(Category::all()->pluck('name', 'id'));
        $form->text('description', __('shop.Description'))->rules('required|max:255');
        $form->text('price', __('shop.price'))->rules('required|integer|numeric|digits_between:1,11');
        $form->number('amount', __('shop.Stock Quantity'))->rules('required|integer|numeric|min:0');
        $form->radio('buy_yn', __('shop.Product Buy'))->options(['Y' => '是', 'N' => '否'])->default('Y');
        $form->radio('display_yn', __('shop.Product Dispaly'))->options(['Y' => '是', 'N' => '否'])->default('Y');;
        $form->image('image', __('image'))->rules('required|image');;

        return $form;
    }
}
