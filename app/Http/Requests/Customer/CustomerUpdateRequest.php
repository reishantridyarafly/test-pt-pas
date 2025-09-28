<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('id');
        return [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $id . ',id',
            'phone' => 'required|string|min:10|max:15|unique:customers,phone,' . $id . ',id',
            'status' => 'required|string|max:255|in:NEW CUSTOMER,LOYAL CUSTOMER',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Nama',
            'email' => 'Email',
            'phone' => 'No Telepon',
            'status' => 'Status',
        ];
    }
}
