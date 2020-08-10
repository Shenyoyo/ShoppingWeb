<?php

namespace App\Admin\Controllers;

use App\Category;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class CategoryController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Category';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Category());

        $grid->column('id', __('shop.ID'));
        $grid->column('name', __('shop.Category Name'));
        $grid->column('display_yn', __('shop.Display'))->bool(['Y' => true, 'N' => false]);
        $grid->column('created_at', __('shop.Created at'));
        $grid->column('updated_at', __('shop.Updated at'));

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
        $show = new Show(Category::findOrFail($id));

        $show->field('id', __('shop.ID'));
        $show->field('name', __('shop.Category Name'));
        $show->field('display_yn', __('shop.Display'));
        $show->field('created_at', __('shop.Created at'));
        $show->field('updated_at', __('shop.Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Category());

        $form->text('name', __('shop.Category Name'))->rules('required|max:255');
        $form->radio('display_yn', __('shop.Display'))->options(['Y' => '是', 'N' => '否'])->default('Y');

        return $form;
    }
}
