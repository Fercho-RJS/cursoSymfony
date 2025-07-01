<?php
namespace App\Common;

class Util
{
    // Métodos útiles, como por ejemplo:
    public static function generarSlug(string $cadena): string
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $cadena)));
    }
}