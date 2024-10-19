<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Course::query()
            ->with('category', 'theme')
            ->get();
        return response()->json([
            'all' => $all
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'title' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'preview' => ['required', 'mimes:png,jpg,jpeg,bmb'],
            'description' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'price' => ['required', 'numeric', 'between:1,999999'],
            'category_id' => ['required'],
            'theme_id' => ['required'],
            'content' => ['required'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'preview.required' => 'Обязательное поле',
            'preview.mimes' => 'Разрешенные форматы: png,jpg,jpeg,bmb',
            'description.required' => 'Обязательное поле',
            'description.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'price.required' => 'Обязательное поле',
            'price.numeric' => 'Тип данных - числовой',
            'price.between' => 'Разрешенный диапазон цены от 1 до 999999',
            'category_id.required' => 'Обязательное поле',
            'theme_id.required' => 'Обязательное поле',
            'content.required' => 'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $path_img = '';
        if ($request->file('preview')) {
            $path_img = $request->file('preview')->store('/public/img/preview');
        }

        $course = new Course();
        $course->title = $request->title;
        $course->preview = '/public/storage/' . $path_img;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->category_id = $request->category_id;
        $course->theme_id = $request->theme_id;
        $course->save();

        foreach ($request->file('content') as $item) {
            $path_file = $item->store('/public/files');

            $file = new File();
            $file->way = '/public/storage/' . $path_file;
            $file->course_id = $course->id;
            $file->save();
        }

        return redirect()->route('CoursePage');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Request $request)
    {
        $course = Course::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(),[
            'title' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'preview' => ['mimes:png,jpg,jpeg,bmb'],
            'description' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'price' => ['required', 'numeric', 'between:1,999999'],
            'category_id' => ['required'],
            'theme_id' => ['required'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'preview.mimes' => 'Разрешенные форматы: png,jpg,jpeg,bmb',
            'description.required' => 'Обязательное поле',
            'description.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'price.required' => 'Обязательное поле',
            'price.numeric' => 'Тип данных - числовой',
            'price.between' => 'Разрешенный диапазон цены от 1 до 999999',
            'category_id.required' => 'Обязательное поле',
            'theme_id.required' => 'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $path_img = '';
        if ($request->file('preview')) {
            $path_img = $request->file('preview')->store('/public/img/preview');
            $course->preview = '/public/storage/' . $path_img;
        }

        $course->title = $request->title;
        $course->description = $request->description;
        $course->price = $request->price;
        $course->category_id = $request->category_id;
        $course->theme_id = $request->theme_id;
        $course->update();

        return redirect()->route('CoursePage');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Request $request)
    {
        $course = Course::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->route('CoursePage');
    }
}
