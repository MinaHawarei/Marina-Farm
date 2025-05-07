<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimalRequest extends FormRequest
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
            'animal_code' => 'required|unique:animals',
            'type' => 'required',
            'breed' => 'nullable|string',
            'age' => 'required|integer|min:0',
            'weight' => 'required|numeric|min:0',
            'health_status' => 'nullable|string',
            'gender' => 'required',
            'origin' => 'required|string',
            'arrival_date' => 'required|date',
            'status' => 'required|string',
            'insemination_type' => 'required|string',
            'created_by' => 'nullable|exists:users,id',
        ];
    }
}
