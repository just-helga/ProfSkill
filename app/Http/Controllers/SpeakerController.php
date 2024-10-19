<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = Speaker::all();
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
            'name' => ['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
            'description' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
        ],[
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Поле может содержать только кириллицу и латиницу',
            'description.required' => 'Обязательное поле',
            'description.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $speaker = new Speaker();
        $speaker->name = $request->name;
        $speaker->description = $request->description;
        $speaker->save();

        return redirect()->route('SpeakerPage');
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
    public function show(Speaker $speaker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Speaker $speaker, Request $request)
    {
        $speaker = Speaker::query()
            ->where('id', $request->id)
            ->first();

        $validate = Validator::make($request->all(),[
            'name' => ['required', 'regex:/[А-Яа-яЁёA-Za-z]/u'],
            'description' => ['required', 'regex:/[А-Яа-яЁёA-Za-z0-9]/u'],
        ],[
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Поле может содержать только кириллицу и латиницу',
            'description.required' => 'Обязательное поле',
            'description.regex' => 'Поле может содержать только кириллицу, латиницу и цифры',
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $speaker->name = $request->name;
        $speaker->description = $request->description;
        $speaker->update();

        return redirect()->route('SpeakerPage');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Speaker $speaker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Speaker $speaker, Request $request)
    {
        $speaker = Speaker::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->route('SpeakerPage');
    }
}
