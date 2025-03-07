<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Student;
use App\Models\Session;

class StudentController extends Controller
{
    public function create(Request $request)
    {
        if(Student::Where('name', $request->input('name'))->Where('father_name', $request->input('father_name'))->exists())
            return response()->json(['message'=>'समान नाम और पिता के नाम के साथ एक और छात्र मौजूद है'], 400);

        if(Student::Where('roll_no', $request->input('roll_no'))->exists())
            return response()->json(['message'=>'समान पंजीक्रम के साथ एक और छात्र मौजूद है'], 400);

        $data = $request->all();
        $data['uuid'] = Str::uuid();
        $student = Student::create($data);
        if(!$student)
        {
            return response()->json(['message'=>'कुछ त्रुटि हुई'], 400);
        }
    }

    public function edit(Request $request, $uuid)
    {
        if(Student::Where('name', $request->input('name'))->Where('father_name', $request->input('father_name'))->Where('uuid', '<>', $uuid)->exists())
            return response()->json(['message'=>'समान नाम और पिता के नाम के साथ एक और छात्र मौजूद है'], 400);

        if(Student::Where('roll_no', $request->input('roll_no'))->Where('uuid', '<>', $uuid)->exists())
            return response()->json(['message'=>'समान पंजीक्रम के साथ एक और छात्र मौजूद है'], 400);

        Student::where('uuid', $uuid)->update($request->all());
    }

    public function get(Request $request, $uuid)
    {
        $student = Student::where('uuid', $uuid)->first();
        return $student;
    }

    public function list(Request $request)
    {
        $students = Student::get();
        return $students;
    }

    public function listFees(Request $request)
    {
        $session = Session::Select('id')->Where('is_active', 1)->first();
        if($session == null)
        {
            return response()->json(['message'=>'No session active'], 400);
        }

        $students = Student::with(['StudentFee' => function ($query) use ($session) {
            $query->where('session_id', $session->id);
        }])->get();

        return $students;
    }

    public function delete(Request $request, $uuid)
    {
        Student::where('uuid', $uuid)->delete();
    }
}
