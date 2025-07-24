<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkEntryRequest extends FormRequest
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
            'mission_task_id' => 'required|exists:mission_tasks,id',
            'entry_date' => 'required|date',
            'hours_worked' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:255',
            'completed' => 'boolean', // New field for marking as completed
        ];
    }
}
