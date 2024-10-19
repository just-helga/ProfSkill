<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Theme::all();
        return response()->json([
            'all' => $all
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'title' => ['required', 'regex:/[А-Яа-яЁёA-Za-z]/u', 'unique:themes'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать только кириллицу и латиницу',
            'title.unique' => 'Тема уже существует',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $theme = new Theme();
        $theme->title = $request->title;
        $theme->save();

        return redirect()->route('ThemePage');
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
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme, Request $request)
    {
        $theme = Theme::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(),[
            'title' => ['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
        ],[
            'title.required' => 'Обязательное поле',
            'title.regex' => 'Поле может содержать только кириллицу и латиницу',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        if (mb_strtolower($theme->title) !== mb_strtolower($request->title)) {
            $validate = Validator::make($request->all(), [
                'title' => ['unique:themes'],
            ],[
                'title.unique' => 'Тема уже существует',
            ]);

            if ($validate->fails()) {
                return response()->json($validate->errors(), 400);
            }
        }

        $theme->title = $request->title;
        $theme->update();

        return redirect()->route('ThemePage');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Theme $theme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme, Request $request)
    {
        $theme = Theme::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->route('ThemePage');
    }
}
