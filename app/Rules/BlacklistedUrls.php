<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class BlacklistedUrls implements Rule
{
    private $blacklistedWords;

    public function __construct()
    {
        $this->blacklistedWords = ['bad', 'sex', 'makemoney'];
    }

    public function passes($attribute, $value)
    {
        return !preg_match('/('.implode('|', $this->blacklistedWords).')/i', $value);
    }

    public function message()
    {
        return 'The URL is blacklisted. Please try another URL.';
    }
}
