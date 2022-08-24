<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Request\Round;

use Illuminate\Foundation\Http\FormRequest;

final class PlayRequest extends FormRequest
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
            'room_id' => [
                'required',
                'integer',
            ],
            'member_id' => [
                'nullable',
                'integer',
            ],
            'cards' => [
                'required',
                'array',
            ],
            'cards.*.suit' => [
                'required',
                'string',
            ],
            'cards.*.number' => [
                'required',
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
            $values['member_id'] = intval($values['member_id']);
            return $values;
        }
        $values['member_id'] = auth()->user()->id;
        return $values;
    }
}
