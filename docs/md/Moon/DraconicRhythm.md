# Moon Draconic Rhythm
The Moon draconic rhythm is the rate at which the moon passes over its lunar nodes, the points of intersection of the lunar orbit with the ecliptic plane.

There are two lunar nodes: the **north node** and the **south node**. They indicate, respectively, that the moon is passing through the northern hemisphere of the ecliptic plane and the southern hemisphere.

*Solar eclipses* can only occur when the moon is at one of the two lunar nodes.

You can obtain a `DraconicRhythm` collection representing the moments when the Moon is over one of the two lunar nodes.
```php
/** @var \MarcoConsiglio\Ephemeris\LaraverlSwissEphemeris $ephemeris */
/** @var \MarcoConsiglio\Ephemeris\Rhythms\Moon\DraconicRhythm $draconic_rhythm */
$draconic_rhythm = $ephemeris->getMoonDraconicRhythm(
    new Carbon, // Starting date and time implementing the Carbon\CarbonInterface. Required.
    7,          // The duration in days of the Moon synodic rhythm. Default: 30 days.
    30          // The duration in minutes of each step in the ephemeris. Default: 60 minutes.
);
```

# Moon Draconic Record
It is a snapshot of the Moon passing over one of the two lunar nodes.
```php
/** @var \MarcoConsiglio\Ephemeris\Records\Moon\DraconicRecord $record */
/**
 * The timestamp of the record.
 * 
 * @var \MarcoConsiglio\Ephemeris\SwissEphemerisDateTime
 */
$record->timestamp;
/**
 * The longitude of the Moon.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle
 */
$record->moon_longitude;
/**
 * The longitude of the North node.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle
 */
$record->north_node_longitude;
/**
 * The longitude of the South node.
 * 
 * @var \MarcoConsiglio\Goniometry\Angle
 */
$record->south_node_longitude;
/**
 * The node cardinality: North or South.
 * 
 * @var \MarcoConsiglio\Ephemeris\Enums\Cardinality
 */
$record->cardinality;
/**
 * The node cardinality name in English.
 * 
 * @var string
 */
$record->cardinality->name;
/**
 * Return true if $record is a North node.
 * 
 * @var bool
 */
$record->isNorthNode();
/**
 * Return true if $record is a South node.
 * 
 * @var bool
 */
$record->isSouthNode();
```

This is an example usage.
```php
// Query the Moon draconic rhythm for one month starting from now.
$draconic_rhythm = $ephemeris->getMoonDraconicRhythm(Carbon::now());
foreach ($draconic_rhythm as $node) {
    $cardinality = $node->cardinality->name;
    $timestamp = $node->timestamp->toDateTimeString();
    echo "$cardinality\t$timestamp\n";
    // North    2025-01-01 12:00:00
}
```