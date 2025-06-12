<?php

namespace ahmedWeb\LivePlatformManager\Http\Requests\Live;

use Illuminate\Foundation\Http\FormRequest;

class FetchZoomConfigRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'platform_code' => 'required|exists:platforms,code',
            'live_account_id' => 'required|exists:live_accounts,id',
            'role' => 'required|integer',
            'user' => 'required|array',
            'user.id' => 'required|integer',
            'user.name' => 'required|string',
            'session_id' => 'required|exists:platform_sessions,id',
        ];
    }
}
