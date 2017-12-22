<?php

namespace App\Http\Requests;

use App\Constants\EmailSchedule;
use App\Constants\NewsSource;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEmailPreferences extends FormRequest
{
    /**
     * Authorisation is handled by the controller.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Return the validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'schedule' => ['required', Rule::in(EmailSchedule::all())],
            'source'   => ['required', Rule::in(NewsSource::all())],
        ];
    }

    /**
     * Restrict everything to POST data.
     *
     * @return array
     */
    protected function validationData()
    {
        return $this->request->all();
    }
}
