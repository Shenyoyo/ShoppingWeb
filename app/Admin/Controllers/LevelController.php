<?php

namespace App\Admin\Controllers;

use Illuminate\Support\Facades\Session;
use App\Http\Requests\LevelRequest;
use App\Http\Requests\LevelUpdateRequest;
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
        $grid->column('name', __('shop.Level Name'))->sortable();
        $grid->column('description', __('shop.Level Description'));
        $grid->column('upgrade', __('shop.Upgrate Condition'))->display(function ($upgrade) {
            return presentPrice($upgrade);
        });
        //統計會員人數
        $grid->column('user', __('shop.Membership'))->display(function ($users) {
            $count = count($users);

            return "<span class='label label-warning'>{$count}</span>";
        });
        $grid->actions(function ($actions) {
            $level = Level::orderBy('level', 'desc')->first();
            //設定不能刪除條件
            if (count($actions->row->user) > 0 || $actions->row->level == 0 || $level->level != $actions->row->level) {
                $actions->disableDelete();
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
        $show = new Show(Level::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
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
        $level = Level::orderBy('level', 'desc')->first();
        $form = new Form(new Level());
        //自訂主鍵
        $form->hidden('level');
        $form->input('level', $level->level + 1);
        
        $form->text('name', __('Name'))
            ->value('VIP' . ($level->level + 1))
            ->readonly()
            ->rules('required|max:255');
        $form->text('description', __('Description'))->required();
        $form->text('upgrade', __('Upgrade'))->required();

        $form->tools(function (Form\Tools $tools) {
            // 關閉刪除按鈕
            $tools->disableDelete();
        });

        return $form;
    }

    //新增時做驗證
    public function store()
    {
        app(LevelRequest::class);
        return $this->form()->store();
    }

    //修改時做驗證
    public function update($id)
    {
        //當前等級存入Session
        session()->put('level', $id);
        app(LevelUpdateRequest::class);
        return $this->form()->update($id);
    }
}
