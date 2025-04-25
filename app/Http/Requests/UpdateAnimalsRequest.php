<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimalsRequest extends FormRequest
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
            //'animal_code' => 'required|string|unique:animals,animal_code,' . $this->route('animal')->id,
            //'type' => 'required|string|max:255',
            //'breed' => 'nullable|string|max:255',
            //'gender' => 'required|string|in:male,female',
            //'origin' => 'required|string|max:255',
            //'arrival_date' => 'required|date',
            //'created_by' => 'required|exists:users,id',
            'insemination_type' => 'required|string|max:255',
            'age' => 'required|integer|min:0',
            'status' => 'required|string|max:255',
            'pen_id' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0',
            'health_status' => 'nullable|string|max:255',
        ];
    }
}
