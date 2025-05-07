<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\health_record;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalsRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;


class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }


    public function buffaloCalf()
    {
        $animals = Animal::where('type', 'Buffalo')->where('status', 'calf')->get();
        return view('buffalo-calf', compact('animals'));
    }
    public function buffaloPregnant()
    {
        $animals = Animal::where('type', 'Buffalo')->where('status', 'pregnant')->get();
        return view('buffalo-pregnant', compact('animals'));
    }
    public function buffaloDairy()
    {
        $startDate =Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate =Carbon::now()->format('Y-m-d');


        $animals = Animal::where('type', 'Buffalo')
        ->where('status', 'dairy')
        ->withSum(['milkProductions as total_milk' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }], 'total_milk')
        ->get();

        return view('buffalo-dairy', compact('animals'));
    }
    public function buffaloDairyMilk(Request $request )
    {
        $startDate = $request->has('datefrom') ? $request->datefrom : Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = $request->has('dateto') ? $request->dateto : Carbon::now()->format('Y-m-d');


        $animals = Animal::where('type', 'Buffalo')
        ->where('status', 'dairy')
        ->withSum(['milkProductions as total_milk' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }], 'total_milk')
        ->get();

        return view('buffalo-dairy', compact('animals'));
    }
    public function buffaloFattening()
    {
        $animals = Animal::where('type', 'Buffalo')->where('status', 'fattening')->get();
        return view('buffalo-fattening', compact('animals'));
    }


    public function cowCalf()
    {
        $animals = Animal::where('type', 'Cow')->where('status', 'calf')->get();
        return view('cow.calf', compact('animals'));
    }
    public function cowPregnant()
    {
        $animals = Animal::where('type', 'Cow')->where('status', 'pregnant')->get();
        return view('cow.pregnant', compact('animals'));
    }
    public function cowDairy()
    {

        $startDate =Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate =Carbon::now()->format('Y-m-d');


        $animals = Animal::where('type', 'Cow')
        ->where('status', 'dairy')
        ->withSum(['milkProductions as total_milk' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }], 'total_milk')
        ->get();

        return view('cow.dairy', compact('animals'));
    }
    public function cowDairyMilk(Request $request)
    {

        $startDate = $request->has('datefrom') ? $request->datefrom : Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = $request->has('dateto') ? $request->dateto : Carbon::now()->format('Y-m-d');


        $animals = Animal::where('type', 'Cow')
        ->where('status', 'dairy')
        ->withSum(['milkProductions as total_milk' => function ($query) use ($startDate, $endDate) {
            $query->whereBetween('date', [$startDate, $endDate]);
        }], 'total_milk')
        ->get();

        return view('cow.dairy', compact('animals'));
    }
    public function cowFattening()
    {
        $animals = Animal::where('type', 'Cow')->where('status', 'fattening')->get();
        return view('cow.fattening', compact('animals'));
    }


    public function milkRecords(Animal $animal)
    {

        return response()->json($animal->milkProductions()->orderBy('date', 'desc')->get());
    }

    public function getHealthRecords($animalId)
    {
        // جلب التقارير الصحية المرتبطة بالحيوان
        $healthRecords = health_record::where('animal_id', $animalId)->get();

        // إرجاع البيانات كـ JSON
        return response()->json($healthRecords);
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

     public function store(StoreAnimalRequest $request)
     {

         // التحقق من البيانات (بدون created_by)
         $validatedData = $request->validate([
             'animal_code' => 'required|unique:animals',
             'type' => 'required',
             'breed' => 'nullable|string',
             'age' => 'required|integer|min:0',
             'weight' => 'required|numeric|min:0',
             'health_status' => 'nullable|string',
             'gender' => 'required',
             'origin' => 'required|string',
             'arrival_date' => 'required|date',
             'status' => 'required|string',
             'pen_id' => 'required|string',
             'insemination_type' => 'required|string',
         ]);

         // إنشاء السجل الجديد مع إضافة created_by
         Animal::create(array_merge($validatedData, [
             'created_by' => auth()->id()
         ]));
         return redirect()->back()->with('success', 'تم إضافة الحيوان بنجاح!');
        }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Animal $animal)
    {
        return response()->json($animal);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalsRequest $request, Animal $animal)
    {

        try {
            $data = $request->except(['_token', '_method', 'created_at', 'updated_at']);

            $animal->update($data);

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
    public function destroy(Animal $animals)
    {
        //
    }


}
