<?php

declare(strict_types=1);

namespace App\Contexts\Lobby\Infrastructure\Http\Request\Room;

use Illuminate\Foundation\Http\FormRequest;

final class EnterRequest extends FormRequest
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

    /**
     * ルートパラメータをマージする
     */
    public function prepareForValidation(): void
    {
        $this->merge(['room_id' => $this->route('id')]);
    }
}
