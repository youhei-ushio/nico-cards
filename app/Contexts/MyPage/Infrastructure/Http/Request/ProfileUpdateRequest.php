<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

final class ProfileUpdateRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'member_name' => [
                'required',
                'string',
                'max:30',
            ],
        ];
    }

    /**
     * @return array
     */
    public function attributes(): array
    {
        return [
            'member_name' => __('my_page.profile.member_name'),
        ];
    }

    /**
     * ユーザIDをパラメータにマージする
     *
     * @param $key
     * @param $default
     * @return mixed|void
     */
    public function validated($key = null, $default = null)
    {
        $values = parent::validated($key, $default);
        $values['member_id'] = auth()->user()->id;
        return $values;
    }
}
