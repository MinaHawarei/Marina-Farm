<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('إدارة الموظفين') }}
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

        <h1 class="text-2xl font-bold mb-4">الموظفين</h1>

        <table class="w-full border border-gray-400 text-center bg-white" id="employee-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">الكود</th>
                    <th class="border px-2 py-1">الاسم</th>
                    <th class="border px-2 py-1">البريد الإلكتروني</th>
                    <th class="border px-2 py-1">الهاتف</th>
                    <th class="border px-2 py-1">الرقم القومي</th>
                    <th class="border px-2 py-1">العنوان</th>
                    <th class="border px-2 py-1">الوظيفة</th>
                    <th class="border px-2 py-1">الراتب</th>
                    <th class="border px-2 py-1">تاريخ التوظيف</th>
                    <th class="border px-2 py-1">الحالة</th>
                    <th class="border px-2 py-1">الحالة الاجتماعية</th>
                    <th class="border px-2 py-1">العمر</th>
                    <th class="border px-2 py-1">ملاحظات</th>
                    <th class="border px-2 py-1">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr data-id="{{ $employee->id }}">
                        <td class="border px-2 py-1">{{ $employee->id }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->name }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->email }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->phone }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->national_id }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->address }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->position }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->salary }}</td>
                        <td class="border px-2 py-1">
                            <input type="date" value="{{ $employee->hiring_date }}" class="w-full px-2 py-1 border rounded" />
                        </td>
                        <td class="border px-2 py-1">
                            <select class="w-full px-2 py-1 border rounded text-center">
                                <option value="نشط" {{ $employee->status == 'نشط' ? 'selected' : '' }}>نشط</option>
                                <option value="غير نشط" {{ $employee->status == 'غير نشط' ? 'selected' : '' }}>غير نشط</option>
                            </select>
                        </td>
                        <td class="border px-2 py-1">
                            <select class="w-full px-2 py-1 border rounded text-center">
                                <option value="اعذب" {{ $employee->marital_status == 'اعذب' ? 'selected' : '' }}>اعذب</option>
                                <option value="متزوج" {{ $employee->marital_status == 'متزوج' ? 'selected' : '' }}>متزوج</option>
                            </select>
                        </td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->age }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $employee->notes }}</td>
                        <td class="border px-2 py-1">
                            <button onclick="saveEmployee(this, {{ $employee->id }})" class="bg-blue-600 text-white px-2 py-1 text-sm rounded">حفظ</button>
                        </td>
                    </tr>
                @endforeach

                <tr data-id="new">
                    <td class="border px-2 py-1 text-gray-400">جديد</td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1"><input type="date" class="w-full px-2 py-1 border rounded" /></td>
                    <td class="border px-2 py-1">
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="نشط">نشط</option>
                            <option value="غير نشط">غير نشط</option>
                        </select>
                    </td>
                    <td class="border px-2 py-1">
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center">
                            <option value="اعذب">اعذب</option>
                            <option value="متزوج">متزوج</option>
                        </select>
                    </td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1">
                        <button onclick="saveEmployee(this, 'new')" style="background-color: #16a34a;" class="bg-green-600 text-white px-2 py-1 text-sm rounded">إضافة</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <form id="employee-form" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="age" id="form-age">
        <input type="hidden" name="_method" value="PUT" id="form-method">
        <input type="hidden" name="id" id="form-id">
        <input type="hidden" name="name" id="form-name">
        <input type="hidden" name="email" id="form-email">
        <input type="hidden" name="phone" id="form-phone">
        <input type="hidden" name="national_id" id="form-national_id">
        <input type="hidden" name="address" id="form-address">
        <input type="hidden" name="position" id="form-position">
        <input type="hidden" name="salary" id="form-salary">
        <input type="hidden" name="hiring_date" id="form-hiring-date">
        <input type="hidden" name="status" id="form-status">
        <input type="hidden" name="marital_status" id="form-marital_status">
        <input type="hidden" name="notes" id="form-notes">
    </form>

    <script>
        function saveEmployee(button, employeeId) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');

            const data = {
                id: employeeId,
                name: cells[1].innerText.trim(),
                email: cells[2].innerText.trim(),
                phone: cells[3].innerText.trim(),
                national_id: cells[4].innerText.trim(),
                address: cells[5].innerText.trim(),
                position: cells[6].innerText.trim(),
                salary: cells[7].innerText.trim(),
                hiring_date: cells[8].querySelector('input')?.value || '',
                status: cells[9].querySelector('select')?.value || '',
                marital_status: cells[10].querySelector('select')?.value || '',
                age: cells[11].innerText.trim(),
                notes: cells[12].innerText.trim(),
            };

            document.getElementById('form-id').value = data.id;
            document.getElementById('form-name').value = data.name;
            document.getElementById('form-email').value = data.email;
            document.getElementById('form-phone').value = data.phone;
            document.getElementById('form-national_id').value = data.national_id;
            document.getElementById('form-address').value = data.address;
            document.getElementById('form-position').value = data.position;
            document.getElementById('form-salary').value = data.salary;
            document.getElementById('form-hiring-date').value = data.hiring_date;
            document.getElementById('form-status').value = data.status;
            document.getElementById('form-marital_status').value = data.marital_status;
            document.getElementById('form-age').value = data.age;
            document.getElementById('form-notes').value = data.notes;

            const form = document.getElementById('employee-form');
            const methodInput = document.getElementById('form-method');

            if (employeeId === 'new') {
                form.action = "{{ route('employees.store') }}";
                methodInput.value = 'POST';
            } else {
                form.action = "{{ url('/employees') }}/" + employeeId;
                methodInput.value = 'PUT';
            }

            form.submit();
        }
    </script>
</x-app-layout>
