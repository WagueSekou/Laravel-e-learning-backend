<?php

namespace App\Admin\Controllers;

use App\Models\CourseType;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseTypeController extends AdminController
{
    //this shows the tree form of the menu(course menu)
    public function index(Content $content){
        $tree = new Tree(new CourseType);
        return $content->header('Course Types')
        ->body($tree);
    }
    
    //just for view
    protected function detail($id)
    {
        $show = new Show(CourseType::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Category'));
        $show->field('description', __('Description'));
        $show->field('order', __('Order'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    //resposible for creating and editing
    protected function form()
    {
        $form = new Form(new CourseType());

        $form->select('parent_id', __('Parent Category'))->options((new CourseType())::selectOptions());
        
        $form->text('title', __('Title'));
        $form->textarea('description', __('Description'));
        $form->number('order', __('Order'));

        return $form;
    }


}
