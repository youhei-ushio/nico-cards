<?php

declare(strict_types=1);

namespace App\Contexts\Game\Infrastructure\Http\Request\Round;

use Illuminate\Foundation\Http\FormRequest;

final class PollingRequest extends FormRequest
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
            'last_event_id' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
