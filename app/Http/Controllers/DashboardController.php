<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\DailyConsumption;
use App\Models\expense;

class DashboardController extends Controller
{
    public function index()
    {
         //DailyConsumption
        $hay_Consumption = DailyConsumption::sum('hay');
        $corn_Consumption = DailyConsumption::sum('corn');
        $soybean_Consumption = DailyConsumption::sum('soybean');
        $soybean_hulls_Consumption = DailyConsumption::sum('soybean_hulls');
        $bran_Consumption = DailyConsumption::sum('bran');
        $silage_Consumption = DailyConsumption::sum('silage');


        //purchases
        $hay_purchases = expense::where('type', 'Hay')->sum('quantity');
        $corn_purchases = expense::where('type', 'Corn')->sum('quantity');
        $soybean_purchases = expense::where('type', 'Soybean')->sum('quantity');
        $soybean_hulls_purchases = expense::where('type', 'Soybean Hulls')->sum('quantity');
        $bran_purchases = expense::where('type', 'Bran')->sum('quantity');
        $silage_purchases = expense::where('type', 'Silage')->sum('quantity');

        //net
        $hay_net = $hay_purchases - $hay_Consumption;
        $corn_net = $corn_purchases - $corn_Consumption;
        $soybean_net = $soybean_purchases - $soybean_Consumption;
        $soybean_hulls_net = $soybean_hulls_purchases - $soybean_hulls_Consumption;
        $bran_net = $bran_purchases - $bran_Consumption;
        $silage_net = $silage_purchases - $silage_Consumption;

        //p
        $hay_net = $hay_net /10000 * 100;
        $corn_net = $corn_net /10000 * 100;
        $soybean_net = $soybean_net /10000 * 100;
        $soybean_hulls_net = $soybean_hulls_net /10000 * 100;
        $bran_net = $bran_net /10000 * 100;
        $silage_net = $silage_net /10000 * 100;




        $animals = Animal::all();
        return view('dashboard', compact(
              'hay_net',
            'corn_net',
            'soybean_net',
            'soybean_hulls_net',
            'bran_net',
            'silage_net',
            'animals',
        ));
    }
}
