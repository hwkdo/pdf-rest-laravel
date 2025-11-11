<?php

namespace Hwkdo\PdfRestLaravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
    * @see \Hwkdo\PdfRestLaravel\PdfRestLaravel
 */
class PdfRestLaravel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Hwkdo\PdfRestLaravel\PdfRestLaravel::class;
    }
}
