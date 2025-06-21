<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('User Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- رسائل التنبيه --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-md">
                    <div class="flex justify-between items-center">
                        <p>{{ session('success') }}</p>
                        <button onclick="this.parentElement.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
                    </div>
                </div>
            @endif

            {{-- قسم الفلاتر --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-6">
                <form action="{{ route('user.logs') }}" method="GET" class="flex flex-wrap items-end gap-4">

                    <div class="flex-1 min-w-[180px]">
                        <label for="causer_id" class="block text-xs font-medium text-gray-700 mb-1">المستخدم</label>
                        <select id="causer_id" name="causer_id" class="block w-full text-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                            <option value="">كل المستخدمين</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('causer_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex-1 min-w-[180px]">
                        <label for="start_date" class="block text-xs font-medium text-gray-700 mb-1">من تاريخ</label>
                        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="block w-full text-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                    </div>

                    <div class="flex-1 min-w-[180px]">
                        <label for="end_date" class="block text-xs font-medium text-gray-700 mb-1">إلى تاريخ</label>
                        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="block w-full text-xs border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 py-2.5">
                    </div>

                    <div class="flex-shrink-0 flex gap-2">
                        <button type="submit" class="w-[80px] px-4 py-2 text-xs font-semibold text-white bg-green-600 hover:bg-green-700 rounded-md shadow-sm flex items-center justify-center gap-1">
                            🔍 عرض
                        </button>
                        <a href="{{ route('user.logs') }}" class="w-[80px] px-4 py-2 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-300 rounded-md shadow-sm flex items-center justify-center gap-1">
                            🧹 مسح
                        </a>
                    </div>

                </form>
            </div>



            <div class="w-full md:w-full px-2">
                <h3 class="text-xl font-bold text-gray-800 mb-4 mt-8">الانشطة</h3>
                <div class="bg-white rounded-xl shadow-md p-6">
                @if(empty($latest_operations))
                    <p class="text-gray-600 text-center">لا توجد عمليات مسجلة حتى الآن.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                    @foreach($latest_operations as $operation)
                        <li class="py-3 flex justify-between items-start">
                        <div>
                            <p class="text-gray-800 font-semibold">{{ $operation->type ?? 'غير محدد' }}</p>
                            <!-- وصف العملية -->
                            <p class="text-gray-600 text-sm mb-1">{{ $operation->description ?? '' }}</p>
                            <!-- تفاصيل إضافية لو موجودة -->
                            @if(!empty($operation->details))
                            <div class="bg-gray-100 text-gray-700 text-xs p-2 rounded">
                                {!! nl2br(e($operation->details)) !!}
                            </div>
                            @endif
                        </div>
                        <div class="text-right whitespace-nowrap pl-2">
                            <p class="text-gray-700">{{ $operation->amount ?? $operation->quantity ?? '' }} {{ $operation->unit ?? '' }}</p>
                            <p class="text-gray-500 text-xs"><span dir="ltr">{{ $operation->created_at ? '' . $operation->created_at : '' }}</span></p>
                        </div>
                        </li>
                    @endforeach
                    </ul>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
