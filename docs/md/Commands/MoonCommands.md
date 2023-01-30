# Moon Commands
## Synodic rhythm
You can query the moon synodic rhythm with the command:
```bash
php artisan swetest:moon_synodic {date} [days [minutes]] [--file=]
```
### Arguments
- **`date`**: The date from which to start the query (format yyyy/mm/dd [HH:ii:ss]).
- `days`: The duration in days of the time interval to query.
- `minutes`: The duration in minutes of each response record.

### Options
- `--file=`: The filename to save the data to (which can be found in `storage/app`).
