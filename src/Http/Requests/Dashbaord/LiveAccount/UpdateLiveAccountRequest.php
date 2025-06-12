<?php

namespace ahmedWeb\LivePlatformManager\Http\Requests\Dashbaord\LiveAccount;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLiveAccountRequest extends FormRequest
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
            // 'platform_id' => 'required|exists:platforms,id',
            'name' => 'required',
            'client_id' => 'required',
            'client_secret' => 'required',
            'account_id' => 'required',
            'sdk_key' => 'required',
            'sdk_secret' => 'required',
            'integeration_type' => 'required',
        ];
    }
}
