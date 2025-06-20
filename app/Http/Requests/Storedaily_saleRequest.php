<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Storedaily_saleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'unit_price' => 'required|numeric|min:0',
            'amount' => 'required|numeric|min:0',
            'paid' => 'required|numeric|min:0',
            'remaining' => 'required|numeric|min:0',
            'date' => 'required|date',
            'payment_due_date' => 'nullable|date',
            'buyer_name' => 'required|string|max:255',
            'buyer_id' => 'nullable|exists:buyers,id',
            'animal_code' => 'nullable|string',
            'description' => 'nullable|string',
        ];
    }
}
