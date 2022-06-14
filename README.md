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
If something went wrong (e.g. like uncorrect permission for the files placed in the folder `/lib`, outbound quering date, ect.) it will throw a `App\SwissEphemeris\SwissEphemerisException` exception.

## Premise
When using the word *collection*, it is meant that the class extends the [Laravel Collection](https://laravel.com/docs/8.x/collections), so you can treat it [*like any other collection*](https://laravel.com/docs/8.x/collections#available-methods).

# Index
## Moon
- [Synodic rhythm](docs/md/SynodicRhythm.md)
- [Moon periods](docs/md/MoonPeriods.md)
- [Moon phases](docs/md/MoonPhases.md)



