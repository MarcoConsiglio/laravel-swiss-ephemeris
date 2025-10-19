# MoonSynodicRhythm
The Moon synodic rhythm is the cycle that the Moon completes with respect to the position of the Sun. It determines several Moon phases and the periods of waxing and waning Moon.

You can obtain a `MoonSynodicRhythm` collection, representing the Moon synodic rhythm over a period of time.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonMoonSynodicRhythm(
    new Carbon, // Starting date and time implementing the Carbon\CarbonInterface. Required.
    7,          // The duration in days of the Moon synodic rhythm. Default: 30 days.
    30          // The duration in minutes of each step in the ephemeris. Default: 60 minutes.
);
```
Behind the scenes, the datetime is converted to `SwissEphemerisDateTime`, which implements `CarbonInterface`.

In this example below, the Moon synodic rhythm of the Moon is obtained starting from December 1, 2022, for the duration of 7 days, recorded every hour. This means the collection will have 168 `MoonSynodicRhythmRecord`.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonMoonSynodicRhythm(new Carbon("2022-01-12"), 7); 
```
You can use it as a normal LaravelCollection.

```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $record */
$record = $synodic_rhythm->first();

$total_record = $synodic_rhythm->count(); // 168
```
# MoonSynodicRhythmRecord
It is a snapshot contained in the [`MoonSynodicRhythm`](#moonsynodicrhythm). It has some read-only properties that represents some raw values of a MoonSynodicRhythm.
```php
/** 
 * The timestamp of the record.
 * 
 * @var \Carbon\Carbon 
 */
$record->timestamp;

/** 
 * The angular distance between the Moon and the Sun, 
 * with the Earth at the vertex. Min: -180°. Max: +180°.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle 
 */
$record->angular_distance;

/**
 * The angular distance expressed in a percentage. 
 * Min -1.0. Max: +1.0.
 * 
 *  @var float
 */
$record->percentage;
```
This is an example usage.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm $synodic_rhythm */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythmRecord $record */
foreach($synodic_rhythm as $record) { 
    echo $record->timestamp."\t".$record->angular_distance."\t".($record->percentage * 100)."%\n"; 
    // 2021-12-12 10:00:00     119° 24' 7.5"    66%
};
```