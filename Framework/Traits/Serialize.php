<?php
namespace App\Framework\Traits;

trait Serialize {

    public function serialize(mixed $value): mixed
    {
        return serialize($value);
    }
}