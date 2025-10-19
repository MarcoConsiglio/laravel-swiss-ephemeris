# MoonPeriods
A Moon period is the period when the angular distance between the Moon and the Sun (with the vertex being the Earth) is positive or negative. When it is negative it is called a **Waning Moon** period (from *Full Moon* to *New Moon*), when it is positive it is called a **Waxing Moon** period (from *New Moon* to *Full Moon*).

You can obtain a `MoonPeriods` collection from a `MoonSynodicRhythm` object. It contains [`MoonPeriod`](#moonperiod) instances.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonSynodicRhythm $synodic_rhythm */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\MoonPeriods $moon_periods */
$moon_periods = $synodic_rhythm->getPeriods();
```
# MoonPeriod
A `MoonPeriod` object can tell you when the period start, stop and if it is waning or waxing.
```php
foreach($moon_periods as $period) {
    $type = "unknown";
    if ($period->isWaxing()) {
        $type = "waxing";
    }
    if ($period->isWaning()) {
        $type = "waning";
    }
    echo "There is a $type moon period starting from {$period->start} to {$period->end}.\n";
}
```