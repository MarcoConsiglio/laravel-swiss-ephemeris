# Moon Phases
In the Moon synodic rhythm, the Moon goes through four phases, repeatedly: *New Moon*, *First Quarter*, *Full Moon*, *Third Quarter*.
The `Phases` collection contains [`PhaseRecord`](#phase-record) objects.

You can obtain the `Phases` collection from a Moon [`SynodicRhythm`](SynodicRhythm.md), specifing which [`Phase`(s)](#phase) you are interested in.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases $moon_phases */
$moon_phases = $synodic_rhythm->getPhases(Phase::cases());
$only_full_moons = $synodic_rhythm->getPhases([MoonPhaseType::FullMoon]);
```
# Phase Record
It represents a moment in which the Moon takes a precise angle with respect to the Sun, from the perspective of the Earth. It has two properties:
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\Phases $moon_phases */
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\PhaseRecord $record */
$record = $moon_phases->first();
/** @var \MarcoConsiglio\Ephemeris\Enums\Moon\Phase $phase*/
$phase = $record->type;
/** @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime */
$date = $record->timestamp
```

# Phase
This is an enumeration for the following Moon phases:
```php
enum MoonPhaseType
{
    case NewMoon;
    case FirstQuarter;
    case FullMoon;
    case ThirdQuarter;
}
```