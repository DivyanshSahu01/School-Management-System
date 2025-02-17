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
    public function get(Request $request, $standard, $medium, $fee_type)
    {
        $Fee = Fee::Select($fee_type.' AS fee')->Where('medium', $medium)->Where('standard', $standard)->first();
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
            'fee_type'=> 'required',
            'amount'=>'required|integer',
            'months'=>'required'
        ]);

        $session = Session::Where('is_active', 1)->first();
        $student = Student::Where('uuid', $studentUUID)->first();
        $fee_type = $request->input('fee_type');
        $amount = $request->input('amount');

        if($student == null)
            return response()->json(['message'=>'Invalid student'], 400);
        if($session == null)
            return response()->json(['message'=>'No session active'], 400);

        $studentFee = StudentFee::firstOrCreate(['session_id'=>$session->id, 'student_id'=>$student->id]);

        if($studentFee != null)
        {
            if($fee_type == 'admission_fee')
            {
                $studentFee->admission_fee += $amount;
                $studentFee->save();
            }
            else if($fee_type == 'exam_fee')
            {
                $studentFee->exam_fee += $amount;
                $studentFee->save();
            }
            else if($fee_type == 'monthly_fee')
            {
                $monthsArray = explode(",", $request->input('months'));
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
                        $updateData[$monthMapping[$month]] = $amount/sizeof($monthsArray);
                    }
                }

                // StudentFee::Where(['session_id'=>$session->id, 'student_id'=>$student->id])->update($updateData);
                $studentFee->update($updateData);
            }
            else if($fee_type == 'other_fee')
            {
                $studentFee->other_fee += $amount;
                $studentFee->save();
            }

            $receipt = new Receipt();
            $receipt->session_id = $session->id;
            $receipt->student_id = $student->id;
            $receipt->amount = $amount;
            $receipt->fee_type = $fee_type;
            if($fee_type == 3)
            {
                $receipt->months = $request->input('months');
            }
            else
            {
                $receipt->months = '';
            }
            $receipt->save();
        }

        return response()->json($student);
    }
}
