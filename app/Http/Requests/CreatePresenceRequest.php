<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreatePresenceRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        $day = date('D', strtotime($this->input('start_time')));

        $this->merge(['status' => 'Normal']);

        if ($day == 'Sat') {

            $this->merge(['status' => 'Sabtu']);
        }

        if ($day == 'Sun') {

            $this->merge(['status' => 'Libur']);
        }

        if ($this->input('is_tanggal_merah') == "1") {

            $this->merge(['status' => 'Libur']);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'employee_name' => ['required'],
            'start_time' => ['required'],
            'finish_time' => ['required'],
            'status' => ['required', Rule::in(
                'Normal',
                'Sabtu',
                'Libur',
            )],
        ];
    }
}
