<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Request\Player;

use Illuminate\Foundation\Http\FormRequest;

final class DetailRequest extends FormRequest
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