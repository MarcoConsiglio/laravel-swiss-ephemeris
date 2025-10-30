# Moon Phase Cycle Periods
A Moon period is the period when the angular distance between the Moon and the Sun (with the vertex being the Earth) is positive or negative. When it is negative it is called a **Waning Moon** period (from *Full Moon* to *New Moon*), when it is positive it is called a **Waxing Moon** period (from *New Moon* to *Full Moon*).

You can obtain Moon `Periods` collection from a [`SynodicRhythm`](SynodicRhythm.md) object. It contains [`Period`](#period) instances.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\SynodicRhythm $synodic_rhythm */
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\Periods $moon_periods */
$moon_periods = $synodic_rhythm->getPeriods();
```
# Period
A `Period` object can tell you when the period start, end and if it is waning or waxing.
```php
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\Periods $moon_periods */
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\Period $period */
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
// There is a waxing moon period starting from <formatted_start_date> to <formatted_end_date>.
// There is a waning moon period starting from <formatted_start_date> to <formatted_end_date>.
```