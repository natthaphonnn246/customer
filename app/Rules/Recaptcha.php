<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;


class Recaptcha implements Rule
{
    public function passes($attribute, $value)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $data = $response->json();

        return $data['success'] ?? false;
    }

    public function message()
    {
        return 'กรุณายืนยันตัวตนอีกครั้ง';
    }
}
