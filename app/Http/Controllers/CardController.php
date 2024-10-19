<?php

namespace App\Http\Controllers;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'number' => ['required', 'numeric', 'min:16', 'unique:cards'],
            'name' => ['required', 'regex:/[А-Яа-яЁёA-Za-z-]/u'],
            'date' => ['required', 'date'],
            'cvv' => ['required', 'numeric', 'min:16']
        ], [
            'number.required' => 'Обязательное поле',
            'number.numeric' => 'Тип данных - числовой',
            'number.min' => 'Номер карты должен состоять из 16 цифр',
            'name.required' => 'Обязательное поле',
            'name.regex' => 'Может содержать только кириллицу, латиницу, пробел и тире',
            'date.required' => 'Обязательное поле',
            'date.date' => 'Тип данных - дата',
            'cvv.required' => 'Обязательное поле',
            'cvv.numeric' => 'Тип данных - числовой',
            'cvv.min' => 'cvv-код должен состоять из 3 цифр',

        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        $card = new Card();

        $card->number = $request->number;
        $card->name = $request->name;
        $card->date = $request->date;
        $card->cvv = $request->cvv;
        $card->user_id = Auth::id();

        $card->save();
        return redirect()->route('PersonalAccountPage');
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
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Card $card, Request $request)
    {
        $card = Card::query()
            ->where('user_id', Auth::id())
            ->where('id', $request->id)
            ->delete();
        return redirect()->route('PersonalAccountPage');
    }
}
