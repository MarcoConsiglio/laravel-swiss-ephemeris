![GitHub License](https://img.shields.io/github/license/MarcoConsiglio/laravel-swiss-ephemeris)
![Static Badge](https://img.shields.io/badge/version-v1.2.0--alpha-white)
<br>
![Static Badge](https://img.shields.io/badge/99%25-rgb(40%2C%20167%2C%2069)?label=Line%20coverage&labelColor=rgb(255%2C255%2C255))
![Static Badge](https://img.shields.io/badge/97%25-rgb(40%2C%20167%2C%2069)?label=Branch%20coverage&labelColor=rgb(255%2C255%2C255))
![Static Badge](https://img.shields.io/badge/79%25-rgb(255%2C193%2C7)?label=Path%20coverage&labelColor=rgb(255%2C255%2C255))

# Laravel Swiss Ephemeris
This laravel package perform queries to the [Swiss Ephemeris](https://github.com/aloistr/swisseph) executable and therefore relies on it using the same AGPL license. Using this package in your Laravel project means you'll need to use the same license. For commercial use, you'll need to [purchase the corresponding license](https://www.astro.com/swisseph/swephprice_e.htm).

The aim of this project is to query ephemeris data to produce planetar positions in order to be used for purposes such as astronomy/astrology, planetary calendar, biodynamic calendar, etc.

In this software, only a fraction of the swiss ephemeris are used: you can query planets, Moon, and known asteroids from **1800** CE (AD) to **2399** CE (AD).

# Development Roadmap
Check the next features in the [development roadmap](./docs/md/Roadmap.md).

# Installation
```bash
composer require marcoconsiglio/ephemeris
```

After installation run this command to publish the Swiss Ephemeris database and config file in your Laravel project. 
```bash
php artisan vendor:publish --provider="MarcoConsiglio\Ephemeris\SwissEphemerisServiceProvider"
```

Remember to grant execution privileges to the `swetest` file, otherwise this software won't work. To do this, run the command 
```bash
chmod u+x ./resources/swiss_ephemeris/swetest
```

To extend the ephemeris data, download the [ephemeris files](https://github.com/aloistr/swisseph/tree/master/ephe) you wish and put them in the `resources/swiss_ephemeris` directory. If you don't know which files to download to extend the time range of the ephemeris, please refer to the [description of the ephemerides](https://www.astro.com/swisseph/swisseph.htm#_Toc112511704).
# Usage
First of all, to query ephemeris data you need to instantiate the 'LaravelSwissEphemeris' class. You need to pass a `PointOfView` class, if none is used, it defaults to `Geocentric` point of view.

```php
use use Illuminate\Support\Facades\Config;
/** @var \MarcoConsiglio\Ephemeris\LaraverlSwissEphemeris $ephemeris */
/** @var \MarcoConsiglio\Ephemeris\Observer\Topocentric $pov */

$pov = new Topocentric(
    Config::get("ephemeris.latitude"), 
    Config::get("ephemeris.longitude"),
    Config::get("ephemeris.altitude")
);
$ephemeris = new LaravelSwissEphemeris(
    $pov,
    Config::get("ephemeris.timezone")
);
```

or instead, another PointOfView class:

```php
use MarcoConsiglio\Ephemeris\Observer\Heliocentric;
/** @var \MarcoConsiglio\Ephemeris\LaraverlSwissEphemeris $ephemeris */

$ephemeris = new LaravelSwissEphemeris(new Heliocentric);
```
Check all [available points of view](docs/md/PointOfView.md) for more info.

~~If something went wrong (e.g. like uncorrect permission for the files placed in the folder `resources/swiss_ephemeris`, outbound quering date, ect.) it will throw a `MarcoConsiglio\Ephemeris\Exceptions\SwissEphemerisException` exception.~~ (This need to be tested and proved).

## Premise
When using the word *collection*, it is meant that the class extends the [Illuminate\Support\Collection](https://laravel.com/docs/12.x/collections), so you can treat it like [*any other collection*](https://laravel.com/docs/12.x/collections).

# API Documentation
For more information, see the API documentation at `./docs/html`.

# Index
## Point of View
- [Point of View](docs/md/PointOfView.md)
## Datetime
- [Swiss Ephemeris Datetime](docs/md/SwissEphemerisDateTime.md)
## Moon Ephemeris
- [Synodic Rhythm](docs/md/Moon/SynodicRhythm.md)
- [Moon Periods](docs/md/Moon/Periods.md)
- [Moon Phases](docs/md/Moon/Phases.md)
- [Moon Anomalistic Rhythm](docs/md/Moon/AnomalisticRhythm.md)
- [Moon Draconic Rhythm](docs/md/Moon/DraconicRhythm.md)



