<?php

namespace App\Http\Controllers;

use NumberFormatter;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Session;
use App\Models\Receipt;

class ReceiptController extends Controller
{
    //
    public function get(Request $request, $receiptId)
    {
        $monthMapping = [
            '1' => 'जनवरी',
            '2' => 'फ़रवरी',
            '3' => 'मार्च',
            '4' => 'अप्रैल',
            '5' => 'मई',
            '6' => 'जून',
            '7' => 'जुलाई',
            '8' => 'अगस्त',
            '9' => 'सितम्बर',
            '10' => 'अक्टूबर',
            '11' => 'नवंबर',
            '12' => 'दिसंबर',
        ];

        $monthNames = [];
        $Receipt = Receipt::with('student')->find($receiptId);

        $totalFee = $Receipt->admission_fee + $Receipt->monthly_fee + $Receipt->exam_fee + $Receipt->other_fee;
        $formatter = new NumberFormatter("hi", NumberFormatter::SPELLOUT);
        $amountInWords = $formatter->format($totalFee)." रुपये";

        $months = explode(",", $Receipt->months);
        foreach($months as $month)
        {
            if(isset($monthMapping[$month]))
            {
                $monthNames[] = $monthMapping[$month];
            }
        }

        $Receipt->months = implode(", ", $monthNames);
        $Receipt->amountInWords = $amountInWords;
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