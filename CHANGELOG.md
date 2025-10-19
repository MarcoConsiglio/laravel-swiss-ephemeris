# Changelog

## [Unreleased]
### Added
- `SwissEphemerisDateTime::availableFormats()` static method that returns all available date time format used by the Swiss Ephemeris.
- `SwissEphemerisServiceProvider` class that publishes `swetest` executable along with asteroid, Moon and planetary ephemeris database files by Swiss Ephemeris tapping ephemeris from 1800 CE (AD) to 2399 CE (AD).
- `LaravelSwissEphemeris` class that provide the starting point to access laravel-swiss-ephemeris API.
- `adambrett/shell-wrapper` dependency in order to programmatically call the `swetest` executable.
- `SwissEphemerisException` class in order to catch exception pertaining the `swetest` executable.
- `MoonPeriods` collection class to obtain a collection of Moon periods.
- `MoonPeriod` class to obatain the start and end timestamp of a waxing or waning moon period.
- `MoonPhases` collection class to collect timestamps of precise lunar phases.
- `MoonPhaseRecord` class to obtain a precise Moon position in respect of the Earth and Sun.
- `MoonSynodicRhythm` collection class to obtain a collection of precise moments of the Moon's synodic rhythm.

### Removed
- `setCreatedWithGregorianDate()`, `setCreatedWithJulianDate()`, `setCreatedWithUniversalTime()`, `setCreatedWithTerrestrialTime()` methods in the `SwissEphemerisDateTime` class. Use `SwissEphemerisDateTime::isUniversalTime` and `SwissEphemerisDateTime::isGregorianDate` properties instead.