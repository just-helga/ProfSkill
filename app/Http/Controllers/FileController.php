<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all = File::all();
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
            'new' => ['required'],
        ],[
            'new.required' => 'Обязательное поле'
        ]);

        if ($validate->fails()) {
            return response()->json($validate->errors(), 400);
        }

        foreach ($request->file('new') as $item) {
            $path_file = $item->store('/public/files');

            $file = new File();
            $file->way = '/public/storage/' . $path_file;
            $file->course_id = $request->id;
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
    public function show(Request $request)
    {
//        $file = File::query()
//            ->where('id', $request->id)
//            ->first();
//        dd($request);
//        $way = 'public/files/b0KdZ1VacMV626kRX4s8i4qy5gOTwFYqFjLNSLfw.pdf';
//        $download = Storage::download($way);
//        return response()->json([
//            'way' => $way,
////            'download' => $download
//        ], 200);
//
//        $a = Storage::download($file->way);
//        return Storage::disk('public')->download($file->way);
//        return Storage::download($file->way);
//        return Storage::download('storage/' . $file->way);
        //        return response()->download->file(storage_path('app/public/' . $file->way));
//        dd(\Illuminate\Support\Facades\File::get(Storage::get($file->way)));
//        return Storage::download($way);
        //нужное
//        return response()->download(Storage::disk('public')->download($file->way));





    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $file, Request $request)
    {
        $file = File::query()
            ->where('id', $request->id)
            ->delete();

        return redirect()->route('CoursePage');
    }
}
