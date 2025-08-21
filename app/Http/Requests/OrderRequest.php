<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'payment_method' => ['required', 'in:credit_card,bank_transfer'],
            'shipping_option' => ['required', 'in:myself,registered,new'],
        ];

        if ($this->input('shipping_option') === 'registered') {
            $rules['registered_address_id'] = ['required', 'exists:shipping_addresses,id'];
        }

        if ($this->input('shipping_option') === 'new') {
            $rules['new_postal_code'] = ['required', 'regex:/^\d{7}$/'];
            $rules['new_address'] = ['required', 'string'];
            $rules['new_recipient_name'] = ['required', 'string'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払方法を選択してください。',
            'shipping_option.required' => 'お届け先を選択してください。',
            'registered_address_id.required' => '登録済住所を選択してください。',
            'new_postal_code.regex' => '郵便番号はハイフンなしの7桁で入力してください。',
        ];
    }

    public function attributes(): array
    {
        return [
            'new_postal_code' => '郵便番号',
            'new_address' => '住所',
            'new_recipient_name' => '宛名',
        ];
    }
}
