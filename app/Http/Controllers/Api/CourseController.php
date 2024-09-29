<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    //this method will return all the course list
    public function courseListe(){
        
        $result= Course::select('name', 'thumbnail', 'lesson_num', 'price', 'id')->get();//selecting our fields  

        return response()->json([
            'code' => 200,
            'msg' => 'Here is my course list',
            'data' => $result
        ], 200);
    }
}
