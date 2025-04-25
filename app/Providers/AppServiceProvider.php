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
            // عدد الجاموس
            $BuffaloCount = Animal::where('type', 'Buffalo')->count();
            // الجاموس الحوامل
            $pregnantBuffalo = Animal::where('type', 'Buffalo')->where('status', 'pregnant')->count();
            // أطفال الجاموس
            $calfBuffalo = Animal::where('type', 'Buffalo')->where('status', 'calf')->count();
            // الجاموس للتسمين
            $fatteningBuffalo = Animal::where('type', 'Buffalo')->where('status', 'fattening')->count();
            // الجاموس الحلوب
            $dairyBuffalo = Animal::where('type', 'Buffalo')->where('status', 'dairy')->count();

            //الحظائر
            //حظيرة 1 رضاعة
            $buffaloPen1 = Animal::where('type', 'Buffalo')->where('pen_id', 'رضاعة')->count();
            //حظيرة 2 فطام
            $buffaloPen2 = Animal::where('type', 'Buffalo')->where('pen_id', 'فطام')->count();
            //حظيرة 3 تحت التلقيح
            $buffaloPen3 = Animal::where('type', 'Buffalo')->where('pen_id', 'تحت التلقيح')->count();
            //حظيرة 4 عشار
            $buffaloPen4 = Animal::where('type', 'Buffalo')->where('pen_id', 'عشار')->count();
            //حظيرة 5 انتظار ولادة
            $buffaloPen5 = Animal::where('type', 'Buffalo')->where('pen_id', 'انتظار ولادة')->count();
            //حظيرة 6 حلاب
            $buffaloPen6 = Animal::where('type', 'Buffalo')->where('pen_id', 'حلاب')->count();
            //حظيرة 7 جفاف
            $buffaloPen7 = Animal::where('type', 'Buffalo')->where('pen_id', 'جفاف')->count();


            // عدد الابقار
            $cowCount = Animal::where('type', 'Cow')->count();
            //  الابقار الحوامل
            $pregnantCow = Animal::where('type', 'Cow')->where('status', 'pregnant')->count();
            // أطفال  الابقار
            $calfCow = Animal::where('type', 'Cow')->where('status', 'calf')->count();
            //  الابقار للتسمين
            $fatteningCow = Animal::where('type', 'Cow')->where('status', 'fattening')->count();
            //  الابقار الحلوب
            $dairyCow = Animal::where('type', 'Cow')->where('status', 'dairy')->count();

              //الحظائر
            //حظيرة 1 رضاعة
            $cowPen1 = Animal::where('type', 'Cow')->where('pen_id', 'رضاعة')->count();
            $cowPen2 = Animal::where('type', 'Cow')->where('pen_id', 'فطام')->count();
            $cowPen3 = Animal::where('type', 'Cow')->where('pen_id', 'تحت التلقيح')->count();
            $cowPen4 = Animal::where('type', 'Cow')->where('pen_id', 'عشار')->count();
            $cowPen5 = Animal::where('type', 'Cow')->where('pen_id', 'انتظار ولادة')->count();
            $cowPen6 = Animal::where('type', 'Cow')->where('pen_id', 'حلاب')->count();
            $cowPen7 = Animal::where('type', 'Cow')->where('pen_id', 'جفاف')->count();




            $view->with([
                'sidebarBuffaloCount'=> $BuffaloCount,
                'pregnantBuffaloCount' => $pregnantBuffalo,
                'calfBuffaloCount' => $calfBuffalo,
                'fatteningBuffaloCount' => $fatteningBuffalo,
                'dairyBuffaloCount' => $dairyBuffalo,

                'buffaloPen1' => $buffaloPen1,
                'buffaloPen2' => $buffaloPen2,
                'buffaloPen3' => $buffaloPen3,
                'buffaloPen4' => $buffaloPen4,
                'buffaloPen5' => $buffaloPen5,
                'buffaloPen6' => $buffaloPen6,
                'buffaloPen7' => $buffaloPen7,

                'cowCount'=> $cowCount,
                'pregnantCow' => $pregnantCow,
                'calfCow' => $calfCow,
                'fatteningCow' => $fatteningCow,
                'dairyCow' => $dairyCow,
                'cowPen1' => $cowPen1,
                'cowPen2' => $cowPen2,
                'cowPen3' => $cowPen3,
                'cowPen4' => $cowPen4,
                'cowPen5' => $cowPen5,
                'cowPen6' => $cowPen6,
                'cowPen7' => $cowPen7,
            ]);
        });
    }
}
