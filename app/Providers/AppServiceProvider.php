<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Animal;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
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
        if (Auth::check()) {
            DB::table('sessions')
                ->where('id', Session::getId())
                ->update(['user_id' => Auth::id()]);
        }
        view()->composer('*', function(View $view) {
            // عدد الجاموس
            $BuffaloCount = Animal::where('type', 'Buffalo')->whereNotIn('status', ['Paid', 'Death'])->count();
            // الجاموس الحوامل
            $pregnantBuffalo = Animal::where('type', 'Buffalo')->where('status', 'pregnant')->whereNotIn('status', ['Paid', 'Death'])->count();
            // أطفال الجاموس
            $calfBuffalo = Animal::where('type', 'Buffalo')->where('status', 'calf')->whereNotIn('status', ['Paid', 'Death'])->count();
            // الجاموس للتسمين
            $fatteningBuffalo = Animal::where('type', 'Buffalo')->where('status', 'fattening')->whereNotIn('status', ['Paid', 'Death'])->count();
            // الجاموس الحلوب
            $dairyBuffalo = Animal::where('type', 'Buffalo')->where('status', 'dairy')->whereNotIn('status', ['Paid', 'Death'])->count();

            //الحظائر
            //حظيرة 1 رضاعة
            $buffaloPen1 = Animal::where('type', 'Buffalo')->where('pen_id', 'رضاعة')->whereNotIn('status', ['Paid', 'Death'])->count();
            //حظيرة 2 فطام
            $buffaloPen2 = Animal::where('type', 'Buffalo')->where('pen_id', 'فطام')->whereNotIn('status', ['Paid', 'Death'])->count();
            //حظيرة 3 تحت التلقيح
            $buffaloPen3 = Animal::where('type', 'Buffalo')->where('pen_id', 'تحت التلقيح')->whereNotIn('status', ['Paid', 'Death'])->count();
            //حظيرة 4 عشار
            $buffaloPen4 = Animal::where('type', 'Buffalo')->where('pen_id', 'عشار')->whereNotIn('status', ['Paid', 'Death'])->count();
            //حظيرة 5 انتظار ولادة
            $buffaloPen5 = Animal::where('type', 'Buffalo')->where('pen_id', 'انتظار ولادة')->whereNotIn('status', ['Paid', 'Death'])->count();
            //حظيرة 6 حلاب
            $buffaloPen6 = Animal::where('type', 'Buffalo')->where('pen_id', 'حلاب')->whereNotIn('status', ['Paid', 'Death'])->count();
            //حظيرة 7 جفاف
            $buffaloPen7 = Animal::where('type', 'Buffalo')->where('pen_id', 'جفاف')->whereNotIn('status', ['Paid', 'Death'])->count();


            // عدد الابقار
            $cowCount = Animal::where('type', 'Cow')->whereNotIn('status', ['Paid', 'Death'])->count();
            //  الابقار الحوامل
            $pregnantCow = Animal::where('type', 'Cow')->where('status', 'pregnant')->whereNotIn('status', ['Paid', 'Death'])->count();
            // أطفال  الابقار
            $calfCow = Animal::where('type', 'Cow')->where('status', 'calf')->whereNotIn('status', ['Paid', 'Death'])->count();
            //  الابقار للتسمين
            $fatteningCow = Animal::where('type', 'Cow')->where('status', 'fattening')->whereNotIn('status', ['Paid', 'Death'])->count();
            //  الابقار الحلوب
            $dairyCow = Animal::where('type', 'Cow')->where('status', 'dairy')->whereNotIn('status', ['Paid', 'Death'])->count();

              //الحظائر
            //حظيرة 1 رضاعة
            $cowPen1 = Animal::where('type', 'Cow')->where('pen_id', 'رضاعة')->whereNotIn('status', ['Paid', 'Death'])->count();
            $cowPen2 = Animal::where('type', 'Cow')->where('pen_id', 'فطام')->whereNotIn('status', ['Paid', 'Death'])->count();
            $cowPen3 = Animal::where('type', 'Cow')->where('pen_id', 'تحت التلقيح')->whereNotIn('status', ['Paid', 'Death'])->count();
            $cowPen4 = Animal::where('type', 'Cow')->where('pen_id', 'عشار')->whereNotIn('status', ['Paid', 'Death'])->count();
            $cowPen5 = Animal::where('type', 'Cow')->where('pen_id', 'انتظار ولادة')->whereNotIn('status', ['Paid', 'Death'])->count();
            $cowPen6 = Animal::where('type', 'Cow')->where('pen_id', 'حلاب')->whereNotIn('status', ['Paid', 'Death'])->count();
            $cowPen7 = Animal::where('type', 'Cow')->where('pen_id', 'جفاف')->whereNotIn('status', ['Paid', 'Death'])->count();




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
