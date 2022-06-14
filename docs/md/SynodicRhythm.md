# SynodicRhythm
The synodic rhythm is the cycle that the Moon completes with respect to the position of the Sun. It determines several Moon phases and the periods of waxing and waning Moon.

You can obtain a `SynodicRhythm` collection, representing the Moon synodic rhythm over a period of time.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonSynodicRhythm(
    new Carbon, // Starting date and time. Required
    7,          // The duration in days of the synodic rhythm. Default: 30
    30          // The duration in minutes of each step in the ephemeris. Default: 60
);
```


```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonSynodicRhythm(new Carbon("2022-01-12"), 7); 

/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record */
$record = $synodic_rhythm->first();

$total_record = $synodic_rhythm->count(); // 168
```
# SynodicRhythmRecord
It is a snapshot contained in the [`SynodicRhythm`](#synodicrhythm). It has some read-only properties that represents some raw values of a SynodicRhythm.
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
 * @var \MarcoConsiglio\Trigonometry\Angle 
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
/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record */
foreach($synodic_rhythm as $record) { 
    echo $record->timestamp."\t".$record->angular_distance."\t".($record->percentage * 100)."%\n"; 
    // 2021-12-12 10:00:00     119° 24' 7.5"    66%
};
```