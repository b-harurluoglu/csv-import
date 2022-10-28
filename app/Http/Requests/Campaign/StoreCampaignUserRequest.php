<?php

namespace App\Http\Requests\Campaign;

use App\Rules\PhoneNumberRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules($data, $campaign)
    {
        return [
            'name'          => 'required',
            'surname'       => 'required',
            'email'         => [
                'required',
                Rule::unique('campaign_users')->where(function ($query) use($data, $campaign) {
                    return $query->where('campaign_id', $campaign->id)->where('email', $data['email']);
                }),
            ],
            'employee_id'         => [
                'required',
                'numeric',
                Rule::unique('campaign_users')->where(function ($query) use($data, $campaign) {
                    return $query->where('campaign_id', $campaign->id)
                        ->where('employee_id', $data['employee_id']);
                }),
            ],
            'phone'         => [
                'required',
                Rule::unique('campaign_users')->where(function ($query) use($data, $campaign) {
                    return $query->where('campaign_id', $campaign->id)
                        ->where('phone', $data['phone']);
                }),
            ],
            'point'         => 'required|numeric',
        ];
    }
}
