# Changelog
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