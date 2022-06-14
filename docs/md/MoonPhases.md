# MoonPhases
In the synodic rhythm, the Moon goes through four phases, repeatedly: *New Moon*, *First Quarter*, *Full Moon*, *Third Quarter*.
The `MoonPhases` collection contains [`MoonPhaseRecord`](#moonphaserecord) objects.

You can obtain the `MoonPhases` collection from a [`SynodicRhythm`](#synodicrhythm), specifing which [`MoonPhaseType`(s)](#moonphasetype) you are interested in.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods $moon_phases */
$moon_phases = $synodic_rhythm->getPhases([
    MoonPhaseType::NewMoon,
    MoonPhaseType::FirstQuarter,
    MoonPhaseType::FullMoon,
    MoonPhaseType::ThirdQuarter
]);
$only_full_moons = $synodic_rhythm->getPhases([MoonPhaseType::FullMoon]);
```
# MoonPhaseRecord
It represents a moment in which the Moon takes a precise angle with respect to the Sun, from the perspective of the Earth. It has two properties:
```php
/**
 * A Moon phase.
 * 
 * @var \MarcoConsiglio\Ephemeris\Rhythms\Enums\MoonPhaseType 
 */
$record->type

/**
 * The exact moment of the Moon phase.
 * 
 * @var \Carbon\Carbon
 */
$record->timestamp
```
Casting the [`MoonPhaseType`](#moonphasetype) enum to string is a little bit tricky.
```php
foreach ($moon_phases => $phase) {
    /** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonPhaseRecord $phase */
    $type = ((array) $phase->type)["name"];
    echo "{$type} is on {$phase->timestamp}.\n";
}
```

# MoonPhaseType
This is a pure enum for the following Moon phases.
```php
enum MoonPhaseType
{
    case NewMoon;
    case FirstQuarter;
    case FullMoon;
    case ThirdQuarter;
}
```