<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $employeeId = $this->route('employee');

        return [
            'image'    => 'required|string',
            'name'     => 'required|string',
            'phone'    => 'required|string|unique:employees,phone,' . $employeeId,
            'division' => 'required|uuid|exists:divisions,id',
            'position' => 'required|string',
        ];
    }
}
