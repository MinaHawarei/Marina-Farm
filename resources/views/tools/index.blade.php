<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Tool Management') }}
        </h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                <div class="flex justify-between items-center">
                    <p>{{ session('success') }}</p>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-green-700">&times;</button>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                <div class="flex justify-between items-center">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button onclick="this.parentElement.parentElement.remove()" class="text-red-700">&times;</button>
                </div>
            </div>
        @endif

        <h1 class="text-2xl font-bold mb-4">المعدات</h1>

        <table class="w-full border border-gray-400 text-center bg-white" id="tool-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">كود</th>
                    <th class="border px-2 py-1">الاسم</th>
                    <th class="border px-2 py-1">الوصف</th>
                    <th class="border px-2 py-1">الفئة</th>
                    <th class="border px-2 py-1">السعر</th>
                    <th class="border px-2 py-1">الاتاحة</th>
                    <th class="border px-2 py-1">اخر صيانة</th>
                    <th class="border px-2 py-1">العمر الافتراضي</th>
                    <th class="border px-2 py-1">معدل الصيانة</th>
                    <th class="border px-2 py-1">اجراءات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tools as $tool)
                    <tr data-id="{{ $tool->id }}">
                        <td class="border px-2 py-1">{{ $tool->id }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $tool->name }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $tool->description }}</td>
                        <td class="border px-2 py-1">
                            <select name="category" class="w-full bg-transparent border-none text-center">
                                <option value="electrical" @selected($tool->category == 'electrical')>electrical</option>
                                <option value="mechanical" @selected($tool->category == 'mechanical')>mechanical</option>
                                <option value="other" @selected($tool->category == 'other')>other</option>
                            </select>
                        </td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $tool->price }}</td>
                        <td class="border px-2 py-1">
                            <select name="available" class="w-full bg-transparent border-none text-center">
                                <option value= 1 @selected($tool->available)>نعم</option>
                                <option value= 0 @selected(!$tool->available)>لا</option>
                            </select>
                        </td>
                        <td class="border px-2 py-1">
                            <input type="date" name="last_maintenance_at" class="w-full bg-transparent text-center" value="{{ $tool->last_maintenance_at }}">
                        </td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $tool->lifespan_years }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $tool->maintenance_frequency }}</td>
                        <td class="border px-2 py-1">
                            <button onclick="saveTool(this, {{ $tool->id }})" class="bg-blue-600 text-white px-2 py-1 text-sm rounded">حفظ</button>
                        </td>
                    </tr>
                @endforeach

                <!-- Row to Add New Tool -->
                <tr data-id="new">
                    <td class="border px-2 py-1 text-gray-400">New</td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1">
                        <select name="category" class="w-full bg-white border border-gray-300 rounded text-center">
                            <option value="">-- Select --</option>
                            <option value="electrical">electrical</option>
                            <option value="mechanical">mechanical</option>
                            <option value="other">other</option>
                        </select>
                    </td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1">
                        <select name="available" class="w-full bg-white border border-gray-300 rounded text-center">
                            <option value= 1>نعم</option>
                            <option value= 0>لا</option>
                        </select>
                    </td>
                    <td class="border px-2 py-1">
                        <input name="last_maintenance_at" type="date" class="w-full bg-white text-center">
                    </td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1">
                    <button onclick="saveTool(this, 'new')" style="background-color: #16a34a;" class="text-white px-2 py-1 text-sm rounded">اضافة</button>                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <form id="tool-form" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="PUT" id="form-method">
        <input type="hidden" name="id" id="form-id">
        <input type="hidden" name="name" id="form-name">
        <input type="hidden" name="description" id="form-description">
        <input type="hidden" name="category" id="form-category">
        <input type="hidden" name="price" id="form-price">
        <input type="hidden" name="available" id="form-available">
        <input type="hidden" name="last_maintenance_at" id="form-last-maintenance">
        <input type="hidden" name="lifespan_years" id="form-lifespan">
        <input type="hidden" name="maintenance_frequency" id="form-frequency">
    </form>

    <script>
        function saveTool(button, toolId) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');
            const selects = row.querySelectorAll('select');
            const dateInput = row.querySelector('input[type="date"]');

            const data = {
                id: toolId,
                name: cells[1].innerText.trim(),
                description: cells[2].innerText.trim(),
                category: selects[0].value,
                price: cells[4].innerText.trim(),
                available: selects[1].value,
                last_maintenance_at: dateInput.value,
                lifespan_years: cells[7].innerText.trim(),
                maintenance_frequency: cells[8].innerText.trim()
            };

            document.getElementById('form-id').value = data.id;
            document.getElementById('form-name').value = data.name;
            document.getElementById('form-description').value = data.description;
            document.getElementById('form-category').value = data.category;
            document.getElementById('form-price').value = data.price;
            document.getElementById('form-available').value = data.available;
            document.getElementById('form-last-maintenance').value = data.last_maintenance_at;
            document.getElementById('form-lifespan').value = data.lifespan_years;
            document.getElementById('form-frequency').value = data.maintenance_frequency;

            const form = document.getElementById('tool-form');
            const methodInput = document.getElementById('form-method');

            if (toolId === 'new') {
                form.action = "{{ route('tools.store') }}";
                methodInput.value = 'POST';
            } else {
                form.action = "{{ url('/tools') }}/" + toolId;
                methodInput.value = 'PUT';
            }

            form.submit();
        }
    </script>
</x-app-layout>
