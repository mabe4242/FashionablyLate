<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            // 一旦すべてnullableにする（エラーはwithValidatorでまとめる）
            'tel1' => ['nullable', 'numeric', 'digits_between:1,5'],
            'tel2' => ['nullable', 'numeric', 'digits_between:1,5'],
            'tel3' => ['nullable', 'numeric', 'digits_between:1,5'],
            'address' => ['required', 'string', 'max:255'],
            'building' => ['nullable', 'string', 'max:255'],
            'category_id' => ['required'],
            'detail' => ['required', 'string', 'max:120']
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tel1 = $this->input('tel1');
            $tel2 = $this->input('tel2');
            $tel3 = $this->input('tel3');
            // いずれかが未入力ならエラー（tel1 に対してまとめて表示）
            if (empty($tel1) || empty($tel2) || empty($tel3)) {
                $validator->errors()->add('tel1', '電話番号をすべて入力してください。');
                return;
            }
            $tel = $tel1 . $tel2 . $tel3;
            if (!preg_match('/^\d{10,11}$/', $tel)) {
                $validator->errors()->add('tel1', '電話番号の桁数は10桁または11桁で入力してください。');
            }
        });
    }

    public function messages()
    {
        return [
            'first_name.required' => '名を入力してください',
            'first_name.string' => '名を文字列で入力してください',
            'first_name.max' => '名を255文字以下で入力してください',
            'last_name.required' => '姓を入力してください',
            'last_name.string' => '姓を文字列で入力してください',
            'last_name.max' => '姓を255文字以下で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスを文字列で入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'email.max' => 'メールアドレスを255文字以下で入力してください',
            'tel1.numeric' => '電話番号は数字で入力してください。',
            'tel2.numeric' => '電話番号は数字で入力してください。',
            'tel3.numeric' => '電話番号は数字で入力してください。',
            'address.required' => '住所を入力してください',
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問合せ内容は120文字以内で入力してください',
        ];
    }
}
