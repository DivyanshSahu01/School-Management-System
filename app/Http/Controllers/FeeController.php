<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fee;
use App\Models\StudentFee;
use App\Models\Student;
use App\Models\Session;
use App\Models\Receipt;

class FeeController extends Controller
{
    //
    public function get(Request $request, $standard, $medium)
    {
        $Fee = Fee::Select('exam_fee', 'admission_fee', 'monthly_fee')->Where('medium', $medium)->Where('standard', $standard)->first();
        $FeeTypes = [
            ['type'=>'exam_fee', 'fee'=>$Fee->exam_fee, 'checked'=>false],
            ['type'=>'admission_fee', 'fee'=>$Fee->admission_fee, 'checked'=>false],
            ['type'=>'monthly_fee', 'fee'=>$Fee->monthly_fee, 'checked'=>false],
            ['type'=>'other_fee', 'fee'=>0, 'checked'=>true],
        ];
        return $Fee;
    }

    public function edit(Request $request, $standard, $medium)
    {
        Fee::Where('medium', $medium)->Where('standard', $standard)->update($request->all());
    }

    public function list(Request $request, $medium)
    {
        $Fees = Fee::Where('medium', $medium)->get();
        return $Fees;
    }

    public function pay(Request $request, $studentUUID)
    {
        $request->validate([
            'selectedFeeTypes'=>'required'
        ]);

        $session = Session::Where('is_active', 1)->first();
        $student = Student::Where('uuid', $studentUUID)->first();
        $feeTypes = json_decode($request->input('selectedFeeTypes'));
        $monthsArray = explode(",", $request->input('months'));
        $noOfMonths = $request->input('months') == '' ? 0 : sizeof($monthsArray);
        $monthlyFee = 0;

        if($student == null)
            return response()->json(['message'=>'Invalid student'], 400);
        if($session == null)
            return response()->json(['message'=>'No session active'], 400);

        $studentFee = StudentFee::firstOrCreate(['session_id'=>$session->id, 'student_id'=>$student->id]);

        $receipt = new Receipt();
        $receipt->session_id = $session->id;
        $receipt->student_id = $student->id;
        $receipt->months = $request->input('months');

        foreach($feeTypes as $feeType)
        {
            if($feeType->type == 'admission_fee')
            {
                $studentFee->admission_fee = $feeType->fee;
                $receipt->admission_fee = $feeType->fee;
            }
            else if($feeType->type == 'exam_fee')
            {
                $studentFee->exam_fee = $feeType->fee;
                $receipt->exam_fee = $feeType->fee;
            }
            else if($feeType->type == 'monthly_fee')
            {
                $monthlyFee = $feeType->fee;
                $receipt->monthly_fee = $monthlyFee * $noOfMonths;
            }
            else if($feeType->type == 'other_fee')
            {
                $studentFee->other_fee = $feeType->fee;
                $receipt->other_fee = $feeType->fee;
            }
        }

        $studentFee->save();
        $receipt->save();

        $monthMapping = [
            '1' => 'january',
            '2' => 'february',
            '3' => 'march',
            '4' => 'april',
            '5' => 'may',
            '6' => 'june',
            '7' => 'july',
            '8' => 'august',
            '9' => 'september',
            '10' => 'october',
            '11' => 'november',
            '12' => 'december',
        ];

        $updateData = [];
        foreach($monthsArray as $month)
        {
            if(isset($monthMapping[$month]))
            {
                $updateData[$monthMapping[$month]] = $monthlyFee;
            }
        }
        $studentFee->update($updateData);

        return response()->json(['id' => $receipt->id]);
    }
}
