<?php

declare(strict_types=1);

namespace App\Contexts\MyPage\Infrastructure\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

final class ProfileEditRequest extends FormRequest
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
