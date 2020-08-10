<?php

namespace App\Admin\Controllers;

use App\Level;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class LevelController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Level';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Level());

        $grid->column('id', __('shop.ID'));
        $grid->column('name', __('shop.Level Name'));
        $grid->column('description', __('shop.Level Description'));
        $grid->column('upgrade', __('shop.Upgrate Condition'))->display(function ($upgrade) {
            return presentPrice($upgrade);
        });
        //統計會員人數
        $grid->column('user', __('shop.Membership'))->display(function ($users) {
            $count = count($users);
            
            return "<span class='label label-warning'>{$count}</span>";
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
        $show = new Show(Level::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('level', __('Level'));
        $show->field('upgrade', __('Upgrade'));
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
        $form = new Form(new Level());
        $form->text('name', __('Name'));
        $form->text('description', __('Description'));
        $form->decimal('upgrade', __('Upgrade'));

        return $form;
    }
}
