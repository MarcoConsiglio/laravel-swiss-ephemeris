<?php
namespace MarcoConsiglio\Ephemeris\Traits;

trait Stringable
{
    protected function toString()
    {

    }

    abstract private function packProperties(): array; 

    protected function getClassName(): string
    {
        return "";
    }
}