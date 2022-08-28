<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Request\Room;

use Illuminate\Foundation\Http\FormRequest;

final class IndexRequest extends FormRequest
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
            'member_id' => [
                'nullable',
                'integer',
            ],
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
        if (!empty($values['member_id']) && app()->environment('local')) {
            // ローカルデバッグ用
            return $values;
        }
        $values['member_id'] = auth()->user()->id;
        return $values;
    }
}
