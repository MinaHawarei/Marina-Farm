<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\daily_sale;
use App\Models\expense;


class TreasuryController extends Controller
{
    public function index()
    {
        // القيم العامة
        $total_income = daily_sale::sum('amount');
        $total_expense = expense::sum('amount');
        $total_debt = daily_sale::where('remaining', '>', 0)->sum('remaining');
        $expected_collections = $total_debt;
        $current_balance = $total_income - $total_expense;

        // آخر العمليات
        $latest_transactions = collect()
            ->merge(daily_sale::select('type', 'description', 'amount', 'date')->latest()->take(5)->get())
            ->merge(expense::select('type', 'description', 'amount', 'date')->latest()->take(5)->get())
            ->sortByDesc('date')
            ->take(5);

        // بيانات الرسم البياني - مجموع الإيرادات والمصروفات حسب الأشهر
        $monthly_data = [];
        foreach (range(1, 12) as $month) {
            $income = daily_sale::whereMonth('date', $month)->sum('amount');
            $expense = expense::whereMonth('date', $month)->sum('amount');
            $monthly_data[] = [
                'month' => $month,
                'income' => $income,
                'expense' => $expense,
            ];
        }

        return view('treasury.index', compact(
            'total_income',
            'total_expense',
            'total_debt',
            'expected_collections',
            'current_balance',
            'latest_transactions',
            'monthly_data'
        ));
    }
    public function income(Request $request)
    {
        $income = daily_sale::query();

        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('date', [$request->datefrom, $request->dateto]);
        }

        $income = $income->get();

        return view('treasury.income', compact('income'));
    }

    public function expense(Request $request)
    {
        $income = expense::query();
        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('date', [$request->datefrom, $request->dateto]);
        }

        $income = $income->get();

        return view('treasury.expense', compact('income'));
    }
    public function receivables(Request $request)
    {
        $income = daily_sale::query();

        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('payment_due_date', [$request->datefrom, $request->dateto]);
        }

        $income->where('remaining', '>', 0);
        $income->orderBy('payment_due_date', 'asc');
        $income = $income->get();

        return view('treasury.receivables', compact('income'));
    }

    public function liabilities(Request $request)
    {
        $income = expense::query();
        // تحقق إذا تم إرسال تاريخ معين
        if ($request->has('datefrom') && $request->has('dateto')) {
            $income->whereBetween('payment_due_date', [$request->datefrom, $request->dateto]);
        }
        $income->where('remaining', '>', 0);
        $income->orderBy('payment_due_date', 'asc');

        $income = $income->get();

        return view('treasury.liabilities', compact('income'));
    }
}
