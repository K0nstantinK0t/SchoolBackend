<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolClassController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $SchoolClasses = SchoolClass::all();
        return response()->json($SchoolClasses, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'teacher_id' => ['required', 'numeric', 'max:255', 'exists:teachers,id'],
            'name' => ['required', 'max:255', 'unique:school_classes'],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 401);
        }

        $input = $request->all();
        $teacher = SchoolClass::create($input);
        // create token

        return response()->json([$teacher], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $SchoolClass = SchoolClass::findOrFail($id);
        return response()->json($SchoolClass, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getWithStudentsAndTeachers($id, Request $request){
        $data = SchoolClass::findOrFail($id)->with('students', 'teacher')->get()->first();
        return response()->json($data, 200);
    }
}
