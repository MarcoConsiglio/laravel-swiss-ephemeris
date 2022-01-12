# Laravel Swiss Ephemeris
This package is a wrapper to the rogergerecke/swiss-ephemeris package which is able to query the Swiss Ephemeris, in order to obtain planets positions, among the other things.

The aim of this project is to query ephemeris data to produce planetar positions in order to be used from astronomy/astrology, calendars, biodynamic agriculture, ect.

In this software, only a fraction of the swiss ephemeris are used: you can query planets, Moon, and known asteroids from **1800** CE (AD) to **2399** CE (AD).

# Installation
```bash
composer require marcoconsiglio/ephemeris
```
# Usage
First of all, to query ephemeris data you need to instantiate it. You need to pass latitude, longitude and timezone to the constructor.

```php
$ephemeris = new LaravelSwissEphemeris(
    $this->config->get("ephemeris.latitude"), 
    $this->config->get("ephemeris.longitude"),
    $this->config->get("ephemeris.timezone")
);

// or instead

$ephemeris = new LaravelSwissEphemeris(
    41.902782,    // Decimal latitude
    12.496366,    // Decimal longitude
    "Europe/Rome" // Timezone
);
```

# Moon
## Synodic Rhythm
The synodic rhythm is the cycle that the Moon completes with respect to the position of the Sun. Determine the four phases of the moon and the periods of waxing and waning moons.

You can obtain a SynodicRhythm object, representing the Moon synodic rhythm over a period of time.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonSynodicRhythm(
    new Carbon, // * Starting date and time.
    7,          // The duration in days of the synodic rhythm. Default: 30
    30          // The duration in minutes of each step in the ephemeris. Default: 60
);
```
If something went wrong (e.g. like uncorrect permission for the files placed in the folder /lib, outbound quering date, ect.) it will throw a `App\SwissEphemeris\SwissEphemerisException` exception.

The SynodicRhythm extends the Laravel [`Illuminate\Support\Collection`](https://laravel.com/docs/8.x/collections) so you can treat it as a normal [`Collection`](https://laravel.com/docs/8.x/collections#available-methods). It contains `SynodicRhythmRecord`(s).

```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythm $synodic_rhythm */
$synodic_rhythm = $ephemeris->getMoonSynodicRhythm(new Carbon("2022-01-12"), 7); 

/** @var \MarcoConsiglio\Ephemeris\Rhythms\SynodicRhythmRecord $record */
$record = $synodic_rhythm->first();

$total_record = $synodic_rhythm->count(); // 168
foreach($synodic_rhythm as $record) { 
    echo $record->timestamp."\t".$record->angular_distance."\t\t\t\t ".($record->percentage * 100)."%\n"; 
    // 2021-12-12 10:00:00     119° 24' 7.5"                    66%
};
```