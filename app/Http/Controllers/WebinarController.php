<?php

namespace App\Http\Controllers;

use App\Models\Webinar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebinarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Webinar::query()
            ->with('theme', 'speaker')
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
            'date' => ['required', 'date'],
            'description' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'theme_id' => ['required'],
            'speaker_id' => ['required'],
            'link' => ['required'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'date.required' => 'Обязательное поле',
            'date.date' => 'Тип данных - дата',
            'description.required' => 'Обязательное поле',
            'description.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'theme_id.required' => 'Обязательное поле',
            'speaker_id.required' => 'Обязательное поле',
            'link.required' => 'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $webinar = new Webinar();
        $webinar->title = $request->title;
        $webinar->date = $request->date;
        $webinar->description = $request->description;
        $webinar->theme_id = $request->theme_id;
        $webinar->speaker_id = $request->speaker_id;
        $webinar->link = $request->link;
        $webinar->save();

        return redirect()->route('WebinarsPage');
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
    public function show(Webinar $webinar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Webinar $webinar, Request $request)
    {
        $webinar = Webinar::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(),[
            'title' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'date' => ['required', 'date'],
            'description' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
            'theme_id' => ['required'],
            'speaker_id' => ['required'],
            'link' => ['required'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'date.required' => 'Обязательное поле',
            'date.date' => 'Тип данных - дата',
            'description.required' => 'Обязательное поле',
            'description.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
            'theme_id.required' => 'Обязательное поле',
            'speaker_id.required' => 'Обязательное поле',
            'link.required' => 'Обязательное поле',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $webinar->title = $request->title;
        $webinar->date = $request->date;
        $webinar->description = $request->description;
        $webinar->theme_id = $request->theme_id;
        $webinar->speaker_id = $request->speaker_id;
        $webinar->link = $request->link;
        $webinar->update();

        return redirect()->route('WebinarsPage');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Webinar $webinar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Webinar $webinar, Request $request)
    {
        $webinar = Webinar::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->route('WebinarsPage');
    }
}
