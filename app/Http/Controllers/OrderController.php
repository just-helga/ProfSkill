<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders_user = Order::query()
            ->where('user_id', Auth::id())
            ->with('course')
            ->get();

        $orders_all = Order::query()
            ->with('course', 'user')
            ->get();

        return response()->json([
            'orders_user' => $orders_user,
            'orders_all' => $orders_all
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $course = Course::query()
            ->where('id', $request->id)
            ->first();

        $order = new Order();
        $order->user_id = Auth::id();
        $order->course_id = $course->id;
        $order->save();
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
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
