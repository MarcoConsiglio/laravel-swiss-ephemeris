<?php
namespace MarcoConsiglio\Ephemeris\Rhythms\Builders\SynodicRhythm\Interfaces;

interface SynodicRhythmBuilder
{
    public function validateData();

    public function buildRecords();

    public function fetchCollection();
}