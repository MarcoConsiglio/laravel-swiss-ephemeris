# SwissEphemerisDateTime
The `SwissEphemerisDateTime` class extends the [`Carbon` class](https://carbon.nesbot.com/) in order to provide support for Swiss Ephemeris datetime formats.

## Available formats
Available formats are:
- Gregorian date universal time (`SwissEphemerisDateTime::GREGORIAN_UT`)
- Gregorian date terrestrial time (`SwissEphemerisDateTime::GREGORIAN_TT`)
- Julian date universal time (`SwissEphemerisDateTime::JULIAN_UT`)
- Julian date terrestrial time (`SwissEphemerisDateTime::JULIAN_TT`)

All available formats are obtainable by the method `SwissEphemerisDateTime::availableFormats()`.

For more information, see the API documentation.