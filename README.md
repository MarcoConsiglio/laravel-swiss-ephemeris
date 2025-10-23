![GitHub License](https://img.shields.io/github/license/MarcoConsiglio/laravel-swiss-ephemeris)<br>
![Static Badge](https://img.shields.io/badge/85%25-rgb(255%2C193%2C7)?label=Line%20coverage&labelColor=rgb(255%2C255%2C255))
![Static Badge](https://img.shields.io/badge/88%25-rgb(255%2C193%2C7)?label=Branch%20coverage&labelColor=rgb(255%2C255%2C255))
![Static Badge](https://img.shields.io/badge/67%25-rgb(255%2C193%2C7)?label=Path%20coverage&labelColor=rgb(255%2C255%2C255))


# Laravel Swiss Ephemeris
This laravel package perform queries to the Swiss Ephemeris executable.

The aim of this project is to query ephemeris data to produce planetar positions in order to be used for purposes such as astronomy/astrology, calendars, biodynamic agriculture, ect.

In this software, only a fraction of the swiss ephemeris are used: you can query planets, Moon, and known asteroids from **1800** CE (AD) to **2399** CE (AD).

# Installation
```bash
composer require marcoconsiglio/ephemeris
```

After installation, composer will automatically publish the Swiss Ephemeris library and the executable in the `resources/swiss_ephemeris` directory. Remember to grant execution privileges to the `resources/swiss_ephemeris/swetest` file, otherwise this software won't work.

To extend the ephemeris data, download the [ephemeris files](https://github.com/aloistr/swisseph/tree/master/ephe) you wish and put them in the `resources/swiss_ephemeris` directory. If you don't know which files to download to extend the time range of the ephemeris, please refer to the [Description of the ephemerides](https://www.astro.com/swisseph/swisseph.htm#_Toc112511704).
# Usage
First of all, to query ephemeris data you need to instantiate the 'LaravelSwissEphemeris' class. You need to pass latitude, longitude and timezone to the constructor.

```php
$ephemeris = new LaravelSwissEphemeris(
    $this->config->get("ephemeris.latitude"), 
    $this->config->get("ephemeris.longitude"),
    $this->config->get("ephemeris.timezone")
);
```

or instead

```php
$ephemeris = new LaravelSwissEphemeris(
    41.902782,      // Decimal latitude
    12.496366,      // Decimal longitude
    "Europe/London" // Timezone
);
```
If something went wrong (e.g. like uncorrect permission for the files placed in the folder `resources/swiss_ephemeris`, outbound quering date, ect.) it will throw a `MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisException` exception.

## Premise
When using the word *collection*, it is meant that the class extends the [Illuminate\Support\Collection](https://laravel.com/docs/12.x/collections), so you can treat it like [*any other collection*](https://laravel.com/docs/12.x/collections).

# API Documentation
For more information, see the API documentation at `./docs/html`.

# Index
## Datetime
- [Swiss Ephemeris datetime](docs/md/SwissEphemerisDateTime.md)
## Moon Ephemeris
- [Synodic rhythm](docs/md/Moon/SynodicRhythm.md)
- [Moon periods](docs/md/Moon/Periods.md)
- [Moon phases](docs/md/Moon/Phases.md)



