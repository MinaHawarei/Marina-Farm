<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\daily_sale;


class TreasuryController extends Controller
{
    public function index()
    {
        return view('treasury.index');
    }
    public function income(Request $request)
    {
        $income = daily_sale::all();
        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('date') && $request->date) {
            $income->whereDate('date', $request->date);
        }
        return view('treasury.income', compact('income'));

    }
    public function expense()
    {
        return view('treasury.expense');
    }
}
