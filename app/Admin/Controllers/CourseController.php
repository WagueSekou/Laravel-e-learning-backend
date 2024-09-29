<?php

namespace App\Admin\Controllers;

use App\Models\CourseType;
use App\Models\Course;
use Encore\Admin\Controllers\AdminController;
use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Tree;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CourseController extends AdminController
{

      /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Course';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        //the first argument is the database field 
        $grid = new Grid(new Course());

        $grid->column('id', __('Id'));

        //
        // $grid->column('user_token', __('Teacher')->display(
        //     function ($token){
        //         //to futher process data, creating any method or operatin in it
        //         return User::where('token', '=', $token)->value('name');

        // }));
        $grid->column('name', __('Name'));
        //50, 50 referce to the image size
        $grid->column('thubnail', __('Thubnail'))->image('', 50, 50);
       
        $grid->column('description', __('Description'));
        $grid->column('type_id', __('Type id'));
        $grid->column('price', __('Price'));
        $grid->column('lesson_num', __('Lesson num'));
        $grid->column('video_length', __('Video length'));
    
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
        $show = new Show(Course::findOrFail($id));

        $show->field('id', __('Id'));
       
        $show->field('name', __('Name'));
        $show->field('thubnail', __('Thubnail'));
        $show->field('description', __('Description')); 
        $show->field('price', __('Price'));
        $show->field('lesson_num', __('Lesson num'));
        $show->field('video_length', __('Video length'));
        $show->field('follow', __('Follow'));
        $show->field('score', __('Score'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }



    //resposible for creating and editing
    protected function form()
    {
        $form = new Form(new Course());
        $form->text('name', __('name'));
        $result = CourseType::pluck('title', __('id'));//getting our categories
        
        //the select method helps you select one of the different options
        $form->select('type_id', __('Category'))->options($result);
        //file is used for video and other format like pdf && other docs
        $form->image('thumbnail', __('Thumbnail'))->uniqueName();
        $form->file('video', __('Video'))->uniqueName();
        $form->decimal('price', __('Price'));// decimal method helps retrieve float from database
        $form->number('lesson_num', __('Lesson number'));
        $form->number('video_length', __('Video lenght'));
        
        //for the posting, who is posting
        $result = User::pluck('name', 'token');
        $form->select('user_token', __('Teacher'))->options($result);
        $form->display('created_at', __('Created at'));
        $form->display('updated_at', __('Updated at'));

        // $form->select('parent_id', __('Parent Category'))->options((new CourseType())::selectOptions());
        
       /* $form->text('title', __('Title'));
        $form->textarea('description', __('Description'));
        $form->number('order', __('Order'));*/

        return $form;
    }



}
