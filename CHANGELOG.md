# Changelog
## 1.3.0-alpha 2026-01-01
### Added
- The ability to set a `PointOfView` class in a `LaravelSwissEphemeris` instance in order to query ephemeris from different points of view.
- Playground testsuit to immediately try out the features of this software.
- The config value 'value_separator' to separate the raw ephemeris output with a char.
### Changed
- The mechanism for parsing ephemeris output, no longer relying on regular expressions, but separating variables with a separator character.

## 1.2.0-alpha 2025-12-19
### Added
- `MarcoConsiglio\Ephemeris\Enums\Cardinality` enum to specify lunar node cardinality (north and south nodes).
- `MarcoConsiglio\Ephemeris\Records\MovingObjectRecord` abstract class extended by all record classes that have a `$daily_speed` property.
- `MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord` class to represent lunar nodes.
- `MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\Strategies\Draconic\Node` class to select correct `DraconicRecord`.
- `MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm` collection to collect `DraconicRecord` instances.
- `MarcoConsiglio\Ephemeris\Templates\Moon\DraconicTemplate` class to query the Moon draconic rhythm.
- `MarcoConsiglio\Ephemeris\Traits\StringableRecord` trait to support the implementation of the `Stringable` interface.
- `MarcoConsiglio\Ephemeris\LaravelSwissEphemeris::getMoonDraconicRhythm()` method to query the Moon draconic rhythm.
### Changed
- Every classes extending the `MarcoConsiglio\Ephemeris\Records\Record` class have now implementation of the `Stringable` interface, meaning they can safely casted to string.
- Namespace of classes `MarcoConsiglio\Ephemeris\Rhythms\Builders\{`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Anomalies\AnomalisticStrategy`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Anomalies\Apogee`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Anomalies\Perigee`  
`}`  
to `MarcoConsiglio\Ephemeris\Rhythms\Builders\{`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Anomalies\AnomalisticStrategy`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Anomalies\Apogee`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Anomalies\Perigee`  
`}`,  
of classes `MarcoConsiglio\Ephemeris\Rhythms\Builders\{`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Phases\FirstQuarter`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Phases\FullMoon`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Phases\NewMoon`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Phases\PhaseStrategy`  
&ensp;&ensp;&ensp;&ensp;`Strategies\Moon\Phases\ThirdQuarter`  
`}`  
to `MarcoConsiglio\Ephemeris\Rhythms\Builders\{`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Phases\FirstQuarter`
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Phases\FullMoon`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Phases\NewMoon`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Phases\PhaseStrategy`  
&ensp;&ensp;&ensp;&ensp;`Moon\Strategies\Phases\ThirdQuarter`  
`}`

## 1.1.1-alpha 2025-12-12
### Changed
- README documentation.
### Fixed
- [#16](https://github.com/MarcoConsiglio/laravel-swiss-ephemeris/issues/16) issue when trying to install dependencies cause an error due to a `post-package-install` script trying to access `vendor/autoload.php` before it has been created. Follow [README.md](https://github.com/MarcoConsiglio/laravel-swiss-ephemeris/blob/master/README.md#installation) documentation to publish vendor files manually after the package installation.
## 1.1.0-alpha 2025-11-26
### Added
- The property `$daily_speed` to all classes extending `Record` class.
- The parameter `$moon_daily_speed` in the constructor of `ApogeeRecord`, `PerigeeRecord`, `DraconicRecord` and `SynodicRhythmRecord` classes of the Moon.
- The properties `AnomalisticStrategy::$angular_delta`.
- The parameter `$sampling_rate` in the constructor of classes: 
  - `MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\{`  
&ensp;&ensp;&ensp;&ensp;`Apogees\FromArray,`  
&ensp;&ensp;&ensp;&ensp;`Perigees\FromArray`  
`}`
  - `MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\Phases\FromSynodicRhythm`
  - `MarcoConsiglio\Ephemeris\Rhythms\Builders\Strategies\Moon\{`  
&ensp;&ensp;&ensp;&ensp;`Anomalies\Apogee`  
&ensp;&ensp;&ensp;&ensp;`Anomalies\Perigee`  
&ensp;&ensp;&ensp;&ensp;`Phases\PhaseStrategy`  
`}`
- `MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm`
- The method `getColumns()` to all classes extending `QueryTemplate`.
### Changed
- Namespace of classes 
  `MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\{`  
&ensp;&ensp;&ensp;&ensp;`Apogees\FromArray,`   
&ensp;&ensp;&ensp;&ensp;`Perigees\FromArray`  
`}` to  
`MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\AnomalisticRhythm\{`  
&ensp;&ensp;&ensp;&ensp;`Apogees\FromArray,`  
&ensp;&ensp;&ensp;&ensp;`Perigees\FromArray`  
`}`, 
of classes  
`MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\{`  
&ensp;&ensp;&ensp;&ensp;`Periods\FromSynodicRhythm,`  
&ensp;&ensp;&ensp;&ensp;`Phase\FromSynodicRhythm`  
`}` to  
`MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\{`  
&ensp;&ensp;&ensp;&ensp;`Periods\FromSynodicRhythm,`  
&ensp;&ensp;&ensp;&ensp;`Phase\FromSynodicRhythm`  
`}`.
- API Documentation

## 1.0.1-alpha 2025-11-01
## Updated
- API Documentation.
## Removed
- Unused code and tests.
  
## 1.0.0-alpha 2025-10-30
### Added
- `SwissEphemerisDateTime::availableFormats()` static method that returns all available date time format used by the Swiss Ephemeris.
- `SwissEphemerisServiceProvider` class that publishes `swetest` executable along with asteroid, Moon and planetary ephemeris database files by Swiss Ephemeris tapping ephemeris from 1800 CE (AD) to 2399 CE (AD).
- `LaravelSwissEphemeris` class that provide the starting point to access laravel-swiss-ephemeris API.
- `LaravelSwissEphemeris::getMoonSynodicRhythm()` method to obtain the `Moon\SynodicRhythmRecord` collection.
- `LaravelSwissEphemeris::getMoonAnomalisticRhythm()` method to obtain the `Moon\AnomalisticRhythm` collection.
- `adambrett/shell-wrapper` dependency in order to programmatically call the `swetest` executable.
- `SwissEphemerisException` class in order to catch exception pertaining the `swetest` executable.
- `Moon\Periods` collection class to obtain a collection of `Moon\Period` instances.
- `Moon\Period` class to obatain the start and end timestamp of a waxing or waning moon period.
- `Moon\Phases` collection class to collect `Moon\PhaseRecord` instances.
- `Moon\Phase` enumeration to represent Moon phases.
- `Moon\PhaseRecord` class to obtain the Moon phase in respect to the Sun.
- `Moon\SynodicRhythm` collection class to collect `Moon\SynodicRhythmRecord` instances.
- `Moon\SynodicRhythmRecord` class to represent a precise moment of the Moon phase cycle.
- `Moon\AnomalisticRhythm` collection class to collect `ApogeeRecord` and `PerigeeRecord`.

### Removed
- `setCreatedWithGregorianDate()`, `setCreatedWithJulianDate()`, `setCreatedWithUniversalTime()`, `setCreatedWithTerrestrialTime()` methods in the `SwissEphemerisDateTime` class. Use `SwissEphemerisDateTime::isUniversalTime` and `SwissEphemerisDateTime::isGregorianDate` properties instead.