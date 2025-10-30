# Moon Anomalistic Rhythm
The moon anomalistic rhythm refers to the times when the moon passes at its farthest and closest points in its orbit, relative to Earth.

## Anomalistic Rhythm
You can obtain an `AnomalisticRhythm` collection representing Moon apogees and perigees over a period of time. The collection will contain both `ApogeeRecord` and `PerigeeRecord`.
```php
/** @var \MarcoConsiglio\Ephemeris\LaraverlSwissEphemeris $ephemeris */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm $anomalistic_rhytm */
$anomalistic_rhytm = $ephemeris->getMoonAnomalisticRhythm(
    new Carbon, // Starting date and time implementing the Carbon\CarbonInterface. Required.
    7,          // The duration in days of the Moon synodic rhythm. Default: 30 days.
    30          // The duration in minutes of each step in the ephemeris. Default: 60 minutes.
);
```

In the example below, the Moon anomalistic rhythm is obtained starting from January 1st, 2025, for the duration of 30 days, recorded every hour.
```php
/** @var \MarcoConsiglio\Ephemeris\LaraverlSwissEphemeris $ephemeris */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm $anomalistic_rhytm */
$anomalistic_rhytm = $ephemeris->getMoonAnomalisticRhythm(
    new Carbon('2025-01-01')
);
```

You can use it like any Laravel Collection.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\AnomalisticRhythm $anomalistic_rhytm */
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\AnomalisticRecord $record */
$record = $anomalistic_rhytm->first();
```

## Apogees
An `AnomalisticRecord` can be an `ApogeeRecord`.
```php
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\ApogeeRecord $record */
/** 
 * The timestamp of the record.
 * 
 * @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime
 */
$record->timestamp;

/** 
 * The longitude of the Moon.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle 
 */
$record->moon_longitude

/** 
 * The longitude of the apogee.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle 
 */
$record->apogee_longitude
```
In an `ApogeeRecord` the two longitudes will be close to each other.

## Perigees
An `AnomalisticRecord` can be a `PerigeeRecord`.
```php
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\PerigeeRecord $record */
/** 
 * The timestamp of the record.
 * 
 * @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime
 */
$record->timestamp;

/** 
 * The longitude of the Moon.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle 
 */
$record->moon_longitude

/** 
 * The longitude of the perigee.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle 
 */
$record->perigee_longitude
```
In an `PerigeeRecord` the two longitudes will be close to each other.