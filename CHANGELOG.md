# Changelog
## [1.1.0-alpha] 2025-11-26
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
of class  
`MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\{`  
&ensp;&ensp;&ensp;&ensp;`Periods\FromSynodicRhythm,`  
&ensp;&ensp;&ensp;&ensp;`Phase\FromSynodicRhythm`  
`}` to  
`MarcoConsiglio\Ephemeris\Rhythms\Builders\Moon\SynodicRhythm\{`  
&ensp;&ensp;&ensp;&ensp;`Periods\FromSynodicRhythm,`  
&ensp;&ensp;&ensp;&ensp;`Phase\FromSynodicRhythm`  
`}`.
- API Documentation

## [1.0.1-alpha] 2025-11-01
## Updated
- API Documentation.
## Removed
- Unused code and tests.
  
## [1.0.0-alpha] 2025-10-30
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