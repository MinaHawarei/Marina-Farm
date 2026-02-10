{{-- Sidebar Navigation --}}
{{-- Dashboard Link --}}
<x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" icon="fas fa-tachometer-alt">
    الرئيسية
</x-sidebar-link>

{{-- Buffalo Section --}}
<x-sidebar-group title="الجاموس" icon="fas fa-cow" :active="request()->routeIs('buffalo.*')" :count="$sidebarBuffaloCount ?? 0">
    <x-sidebar-sublink :href="route('buffalo.index')" :active="request()->routeIs('buffalo.index')" icon="fas fa-list" :count="$sidebarBuffaloCount ?? 0">
        الرئيسية
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('buffalo.pregnant')" :active="request()->routeIs('buffalo.pregnant')" icon="fas fa-baby" :count="$pregnantBuffaloCount ?? 0">
        عشار
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('buffalo.dairy')" :active="request()->routeIs('buffalo.dairy')" icon="fas fa-wine-bottle" :count="$dairyBuffaloCount ?? 0">
        حلاب
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('buffalo.fattening')" :active="request()->routeIs('buffalo.fattening')" icon="fas fa-weight" :count="$fatteningBuffaloCount ?? 0">
        تسمين
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('buffalo.calf')" :active="request()->routeIs('buffalo.calf')" icon="fas fa-paw" :count="$calfBuffaloCount ?? 0">
        مواليد
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Cow Section --}}
<x-sidebar-group title="الابقار" icon="fas fa-cow" :active="request()->routeIs('cow.*')" :count="$cowCount ?? 0">
    <x-sidebar-sublink :href="route('cow.index')" :active="request()->routeIs('cow.index')" icon="fas fa-list" :count="$cowCount ?? 0">
        الرئيسية
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('cow.pregnant')" :active="request()->routeIs('cow.pregnant')" icon="fas fa-baby" :count="$pregnantCow ?? 0">
        عشار
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('cow.dairy')" :active="request()->routeIs('cow.dairy')" icon="fas fa-wine-bottle" :count="$dairyCow ?? 0">
        حلاب
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('cow.fattening')" :active="request()->routeIs('cow.fattening')" icon="fas fa-weight" :count="$fatteningCow ?? 0">
        تسمين
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('cow.calf')" :active="request()->routeIs('cow.calf')" icon="fas fa-paw" :count="$calfCow ?? 0">
        مواليد
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Daily Section --}}
<x-sidebar-group title="اليومية" icon="fas fa-calendar-day" :active="request()->routeIs('daily.*')">
    <x-sidebar-sublink :href="route('daily.index')" :active="request()->routeIs('daily.index')" icon="fas fa-home">
        الرئيسية
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('daily.production')" :active="request()->routeIs('daily.production')" icon="fas fa-industry">
        الانتاج اليومي
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('daily.consumption')" :active="request()->routeIs('daily.consumption')" icon="fas fa-utensils">
        الاستهلاك اليومي
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Treasury Section --}}
<x-sidebar-group title="الخزينة" icon="fas fa-piggy-bank" :active="request()->routeIs('treasury.*')">
    <x-sidebar-sublink :href="route('treasury.index')" :active="request()->routeIs('treasury.index')" icon="fas fa-home">
        الرئيسية
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('treasury.income')" :active="request()->routeIs('treasury.income')" icon="fas fa-money-bill-wave">
        ايرادات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('treasury.expense')" :active="request()->routeIs('treasury.expense')" icon="fas fa-receipt">
        مصروفات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('treasury.liabilities')" :active="request()->routeIs('treasury.liabilities')" icon="fas fa-hand-holding-usd">
        مديونات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('treasury.receivables')" :active="request()->routeIs('treasury.receivables')" icon="fas fa-hand-holding-heart">
        تحصيلات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('treasury.daily')" :active="request()->routeIs('treasury.daily')" icon="fas fa-calendar-day">
        يومية
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Stock Section --}}
<x-sidebar-group title="المخزون" icon="fas fa-boxes" :active="request()->routeIs('stock.*')">
    <x-sidebar-sublink :href="route('stock.producs')" :active="request()->routeIs('stock.producs')" icon="fas fa-box-open">
        منتجات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('stock.feeds')" :active="request()->routeIs('stock.feeds')" icon="fas fa-haykal">
        اعلاف
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('stock.other')" :active="request()->routeIs('stock.other')" icon="fas fa-ellipsis-h">
        اخري
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Tools Section --}}
<x-sidebar-group title="الصيانة و المعدات" icon="fas fa-tools" :active="request()->routeIs('tools.*')">
    <x-sidebar-sublink :href="route('tools.index')" :active="request()->routeIs('tools.index')" icon="fas fa-list">
        المعدات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('tools.schedule')" :active="request()->routeIs('tools.schedule')" icon="fas fa-calendar-check">
        جدول الصيانة
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Clients Section --}}
<x-sidebar-group title="العملاء و الموردين" icon="fas fa-users" :active="request()->routeIs('clients.*')">
    <x-sidebar-sublink :href="route('clients.index')" :active="request()->routeIs('clients.index')" icon="fas fa-user-tie">
        العملاء
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('clients.suppliers')" :active="request()->routeIs('clients.suppliers')" icon="fas fa-truck">
        الموردين
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- Reports Section --}}
<x-sidebar-group title="التقارير و التحليلات" icon="fas fa-chart-bar" :active="request()->routeIs('reports.*')">
    <x-sidebar-sublink :href="route('reports.production')" :active="request()->routeIs('reports.production')" icon="fas fa-chart-line">
        تقارير الانتاج
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('reports.sales')" :active="request()->routeIs('reports.sales')" icon="fas fa-chart-pie">
        تقارير المبيعات
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('reports.financial')" :active="request()->routeIs('reports.financial')" icon="fas fa-file-alt">
        تقارير مالية
    </x-sidebar-sublink>
</x-sidebar-group>

{{-- HR Section --}}
<x-sidebar-group title="الموارد البشرية" icon="fas fa-users-cog" :active="request()->routeIs('user.*')">
    <x-sidebar-sublink :href="route('user.employees')" :active="request()->routeIs('user.employees')" icon="fas fa-user-friends">
        الموظفون
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('user.index')" :active="request()->routeIs('user.index')" icon="fas fa-user-cog">
        ادارة المستخدمين
    </x-sidebar-sublink>
    <x-sidebar-sublink :href="route('user.logs')" :active="request()->routeIs('user.logs')" icon="fas fa-clipboard-list">
        سجل الأنشطة
    </x-sidebar-sublink>
</x-sidebar-group>
