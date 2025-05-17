<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('إدارة العملاء') }}
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

        <h1 class="text-2xl font-bold mb-4">العملاء</h1>

        <table class="w-full border border-gray-400 text-center bg-white" id="client-table">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border px-2 py-1">الكود</th>
                    <th class="border px-2 py-1">اسم الشركة</th>
                    <th class="border px-2 py-1">الشخص المسؤول</th>
                    <th class="border px-2 py-1">الهاتف</th>
                    <th class="border px-2 py-1">البريد الإلكتروني</th>
                    <th class="border px-2 py-1">العنوان</th>
                    <th class="border px-2 py-1">نوع المشتريات</th>
                    <th class="border px-2 py-1">اجمالي قيمة المشتريات</th>
                    <th class="border px-2 py-1">اجمالي المديونية</th>
                    <th class="border px-2 py-1">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                    <tr data-id="{{ $client->id }}">
                        <td class="border px-2 py-1">{{ $client->id }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $client->name }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $client->contact_person }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $client->phone }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $client->email }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $client->address }}</td>
                        <td class="border px-2 py-1" contenteditable="true">{{ $client->purchase_type }}</td>
                        <td class="border px-2 py-1">{{ $client->sales_sum_amount }}</td>
                        <td class="border px-2 py-1">{{ $client->sales_sum_remaining }}</td>
                        <td class="border px-2 py-1">
                            <button onclick="saveClient(this, {{ $client->id }})" class="bg-blue-600 text-white px-2 py-1 text-sm rounded">حفظ</button>
                        </td>
                    </tr>
                @endforeach

                <!-- صف الإضافة -->
                <tr data-id="new">
                    <td class="border px-2 py-1 text-gray-400">جديد</td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1" contenteditable="true"></td>
                    <td class="border px-2 py-1"></td>
                    <td class="border px-2 py-1"></td>
                    <td class="border px-2 py-1">
                        <button onclick="saveClient(this, 'new')" style="background-color: #16a34a;" class="bg-green-600 text-white px-2 py-1 text-sm rounded">إضافة</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <form id="client-form" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="_method" value="PUT" id="form-method">
        <input type="hidden" name="id" id="form-id">
        <input type="hidden" name="name" id="form-name">
        <input type="hidden" name="contact_person" id="form-contact">
        <input type="hidden" name="phone" id="form-phone">
        <input type="hidden" name="email" id="form-email">
        <input type="hidden" name="address" id="form-address">
        <input type="hidden" name="purchase_type" id="form-type">
    </form>

    <script>
        function saveClient(button, clientId) {
            const row = button.closest('tr');
            const cells = row.querySelectorAll('td');

            const data = {
                id: clientId,
                name: cells[1].innerText.trim(),
                contact_person: cells[2].innerText.trim(),
                phone: cells[3].innerText.trim(),
                email: cells[4].innerText.trim(),
                address: cells[5].innerText.trim(),
                purchase_type: cells[6].innerText.trim()
            };

            document.getElementById('form-id').value = data.id;
            document.getElementById('form-name').value = data.name;
            document.getElementById('form-contact').value = data.contact_person;
            document.getElementById('form-phone').value = data.phone;
            document.getElementById('form-email').value = data.email;
            document.getElementById('form-address').value = data.address;
            document.getElementById('form-type').value = data.purchase_type;

            const form = document.getElementById('client-form');
            const methodInput = document.getElementById('form-method');

            if (clientId === 'new') {
                form.action = "{{ route('clients.store') }}";
                methodInput.value = 'POST';
            } else {
                form.action = "{{ url('/clients') }}/" + clientId;
                methodInput.value = 'PUT';
            }

            form.submit();
        }
    </script>
</x-app-layout>
