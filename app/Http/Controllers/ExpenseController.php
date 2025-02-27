<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Expense;

class ExpenseController extends Controller
{
    //
    public function list(Request $request, $fromDate, $toDate)
    {
        $Transactions = DB::select("SELECT amount * -1 AS amount, description, DATE_FORMAT(created_at, '%d/%m/%Y - %r') AS created_at FROM expenses WHERE DATE(created_at) BETWEEN '$fromDate' AND '$toDate' UNION ALL SELECT admission_fee + monthly_fee + exam_fee + other_fee AS amount, 'फीस प्राप्त हुई' AS description, DATE_FORMAT(created_at, '%d/%m/%Y - %r') AS created_at FROM receipts WHERE DATE(created_at) BETWEEN '$fromDate' AND '$toDate' ORDER BY created_at");

        return response()->json($Transactions);
    }

    public function create(Request $request)
    {
        Expense::create($request->all());
    }
}