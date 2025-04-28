<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDailyConsumptionRequest extends FormRequest
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
            'hay' => 'required',
            'clover' => 'required',
            'corn' => 'required',
            'soybean' => 'required',
            'soybean_hulls' => 'required',
            'bran' => 'required',
            'silage' => 'required',
            'gasoline' => 'required',
            'solar' => 'required',
            'consumptions_date' => 'required',
            'created_by' => 'nullable|exists:users,id',
        ];

    }
}
