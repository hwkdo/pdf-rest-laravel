<?php

namespace Hwkdo\PdfRestLaravel;

use Illuminate\Support\Facades\DB;

class PdfRestLaravel {

    protected string $api_key;

    public function __construct()
    {
        $this->api_key = config('pdf-rest-laravel.api_key');
    }

    public function getApiKey(): string
    {
        return $this->api_key;
    }
}
