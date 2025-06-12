<?php

namespace ahmedWeb\LivePlatformManager\Http\Requests\Live;

use ahmedWeb\LivePlatformManager\Response\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class DeleteLiveRequest extends ApiRequest
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
            'platform_type' => 'required|integer',
            'session_id' => 'required|exists:platform_sessions,id',
        ];
    }
}
