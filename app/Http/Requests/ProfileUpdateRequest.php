<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'last_name'        => ['required', 'string', 'max:255'],
            'first_name'       => ['required', 'string', 'max:255'],
            'last_name_kana'   => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー]+$/u'],
            'first_name_kana'  => ['required', 'string', 'max:255', 'regex:/^[ァ-ヶー]+$/u'],
            'postal_code'      => ['required', 'digits:7'],
            'address'          => ['required', 'string', 'max:255'],
            'phone_number'     => ['required', 'digits_between:10,11'],
            'email'            => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
        ];
    }

    public function attributes(): array
    {
        return [
            'last_name' => '姓',
            'first_name' => '名',
            'last_name_kana' => 'セイ',
            'first_name_kana' => 'メイ',
            'email' => 'メールアドレス',
            'postal_code' => '郵便番号',
            'address' => '住所',
            'phone_number' => '電話番号',
        ];
    }
}
