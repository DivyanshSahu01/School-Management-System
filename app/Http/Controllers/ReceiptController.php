<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Session;
use App\Models\Receipt;

class ReceiptController extends Controller
{
    //
    public function get(Request $request, $receiptId)
    {
        $Receipt = Receipt::with('student')->find($receiptId);
        return view('print-receipt', $Receipt);
    }

    public function list(Request $request, $studentUUID)
    {
        $session = Session::select('id')->Where('is_active', 1)->first();
        $student = Student::select('id')->Where('uuid', $studentUUID)->first();

        if($student == null)
            return response()->json(['message'=> 'Invalid student'], 400);
        if($session == null)
            return response()->json(['message'=>'No session active'], 400);

        $Receipts = Receipt::Where('student_id', $student->id)->Where('session_id', $session->id)->get();
        return $Receipts;
    }
}