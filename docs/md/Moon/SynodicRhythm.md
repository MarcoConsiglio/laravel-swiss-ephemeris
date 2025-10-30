# Moon Synodic Rhythm
The Moon synodic rhythm is the cycle that the Moon completes with respect to the position of the Sun. It determines several Moon phases and the periods of waxing and waning Moon.

You can obtain a `SynodicRhythm` collection, representing the Moon synodic rhythm over a period of time.
```php
/** @var \MarcoConsiglio\Ephemeris\LaraverlSwissEphemeris $ephemeris */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonSynodicRhythm(
    new Carbon, // Starting date and time implementing the Carbon\CarbonInterface. Required.
    7,          // The duration in days of the Moon synodic rhythm. Default: 30 days.
    30          // The duration in minutes of each step in the ephemeris. Default: 60 minutes.
);
```

In this example below, the Moon synodic rhythm is obtained starting from January 1st, 2022, for the duration of 7 days, recorded every hour. This means the collection will have 168 Moon `SynodicRhythmRecord`.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonMoonSynodicRhythm(new Carbon("2022-01-01"), 7); 
```
You can use it as a normal Laravel Collection.

```php
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord $record */
$record = $synodic_rhythm->first();

$total_record = $synodic_rhythm->count(); // 168
```
# Moon Synodic Rhythm Record
It is a snapshot contained in the [`Moon Synodic Rhythm`](#moon-synodic-rhythm). It has some read-only properties that represents some raw values of records found in `SynodicRhythm` collection.
```php
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord $record */
/** 
 * The timestamp of the record.
 * 
 * @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime
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
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm $synodic_rhythm */
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\SynodicRhythmRecord $record */
foreach($synodic_rhythm as $record) { 
    echo $record->timestamp."\t".$record->angular_distance."\t".$record->percentage."%\n"; 
    // 2021-12-12 10:00:00     119° 24' 7.5"    66%
};
```