<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\Interfaces;

interface Builder
{
    public function validateData();

    public function buildRecords();

    public function fetchCollection();
}