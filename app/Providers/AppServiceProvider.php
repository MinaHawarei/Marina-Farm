<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Animal;
use Illuminate\View\View;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        view()->composer('*', function(View $view) {
            $BuffaloCount = Animal::where('type', 'Buffalo')->count();

            $pregnantBuffalo = Animal::where('type', 'Buffalo')->where('status', 'pregnant')->count();
            // أطفال الجاموس
            $calfBuffalo = Animal::where('type', 'Buffalo')->where('status', 'calf')->count();

            // الجاموس للتسمين
            $fatteningBuffalo = Animal::where('type', 'Buffalo')->where('status', 'fattening')->count();

            // الجاموس الحلوب
            $dairyBuffalo = Animal::where('type', 'Buffalo')->where('status', 'dairy')->count();

            $view->with([
                'sidebarBuffaloCount'=> $BuffaloCount,
                'pregnantBuffaloCount' => $pregnantBuffalo,
                'calfBuffaloCount' => $calfBuffalo,
                'fatteningBuffaloCount' => $fatteningBuffalo,
                'dairyBuffaloCount' => $dairyBuffalo
            ]);
        });
    }
}
