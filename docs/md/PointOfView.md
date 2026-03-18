# Point of View
You can query the Swiss Ephemeris different points of view.

## Geocentric
The default point of view. The observer is placed at the center of the Earth.

## Heliocentric
The point of view from the center of the Sun.

## Topocentric
The point of view from a specific place on the Earth surface.

It needs three variables:
- Longitude (decimal degrees)
- Latitude (decimal degrees)
- Altitude (meters)

## Planetocentric
The point of view from the center of a specific planet.
It needs one variable:
- The planet where the observer is located

## Barycentric
The point of view from the barycenter of the solar system which is close to the Sun, but not its center.

# Choose a point of view
To change the point of view before performing the query set it on the `LaravelSwissEphemeris` instance.
```php
$ephemeris->pov = new Topocentric(
    48.3, // Latitude
    14.2, // Longitude
    528   // Altitude
)
```

## Not acceptable point of view
Some `QueryTemplate` classes silently discard the chosed point of view, because it is meaningless, like when querying a `DraconicTemplate` or `AnomalisticTemplate`. These two, but not limited to, silently set the POV to geocentric, beacuse the events described in the ephemeris response are the same whichever POV you choose.