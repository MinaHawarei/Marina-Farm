<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
        <div class="flex-1 overflow-y-auto p-8">

            <!-- Email Statistics Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                <h3 class="text-xl font-semibold mb-4">الموردين</h3>
                <p class="text-gray-500 mb-4">Last Campaign Performance</p>
                <div class="flex justify-between">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">11%</div>
                        <div class="text-gray-500">Open Rate</div>
                    </div>
                    <!-- باقي النسب -->
                </div>
            </div>

            <!-- Users Behavior Card -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Users Behavior</h3>
                    <p class="text-gray-500 mb-4">24 Hours performance</p>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <span>9:00AM</span>
                            <span class="font-semibold">120 visits</span>
                        </li>
                        <!-- باقي الأوقات -->
                    </ul>
                </div>

                <!-- Open & Bounce Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-semibold mb-4">Open & Bounce & Unsubscribe</h3>
                    <p class="text-gray-500">Campaign sent 2 days ago</p>
                </div>
            </div>

            <!-- 2017 Sales Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-8">
                <h3 class="text-xl font-semibold mb-4">2017 Sales</h3>
                <p class="text-gray-500 mb-4">All products including Taxes</p>
                <div class="flex items-end h-64 mt-4">
                    <div class="flex-1 flex flex-col items-center">
                        <div class="bg-blue-500 w-full rounded-t" style="height: 30%;"></div>
                        <span class="mt-2 text-sm">Jan</span>
                    </div>
                    <!-- باقي الأشهر -->
                </div>
            </div>

            <!-- Tasks Card -->
            <div class="bg-white rounded-lg shadow-md p-6 mt-8">
                <h3 class="text-xl font-semibold mb-4">Tasks</h3>
                <p class="text-gray-500 mb-4">Backend development</p>
                <ul class="space-y-4">
                    <li class="flex items-start">
                        <input type="checkbox" class="mt-1 mr-2">
                        <span>Sign contract for "What are conference organizers afraid of?"</span>
                    </li>
                    <!-- باقي المهام -->
                </ul>
            </div>
        </div>
</x-app-layout>
