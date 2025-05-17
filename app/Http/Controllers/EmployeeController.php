<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Http\Requests\UpdateemployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'national_id' => 'nullable|string',
            'address' => 'nullable|string',
            'position' => 'required|string',
            'salary' => 'nullable|numeric',
            'hiring_date' => 'required|date',
            'status' => 'required|in:نشط,غير نشط',
            'marital_status' => 'nullable',
            'age' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $data['created_by'] = auth()->id();
        Employee::create($data);

        return redirect()->back()->with('success', 'تمت إضافة الموظف بنجاح');
    }

    /**
     * Display the specified resource.
     */
    public function show(employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateemployeeRequest $request, employee $employee)
    {
        try {
            $data = $request->except(['_token', '_method', 'created_at', 'updated_at']);
            $data['created_by'] = auth()->id();
            $employee = employee::find($request->id);
            $employee->update($data);
            return redirect()->back()->with([
                'success' => 'تم تحديث البيانات بنجاح',
                'updated_data' => $data
            ]);

        } catch (\Exception $e) {
            return redirect()->back()->with([
                'error' => 'حدث خطأ أثناء التحديث: ' . $e->getMessage()
            ]);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(employee $employee)
    {
         $employee->delete();
        return redirect()->back()->with('success', 'تم حذف الموظف');
    }
}
