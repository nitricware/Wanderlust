# Wanderlust

Wanderlust is a project that uses open data to provide GeoJSON and GPX files of hiking routes.

## Contribute

I'm happy to accept pull requests that enhance the project or fix some bugs.

An improved UI or hiking routes from other cities would be a nice sight...

## Running on your own

This project comes with a docker and docker-compose file. You must also run ```composer install``` from the ```src``` directory before you're able to run the project.

Once it's running, goto ```localhost/fetchJSON.php``` to download the open data json file and process the data.

This project requires PHP 7.4

## Data sources

- Wanderwege Wien: https://data.wien.gv.at

## Version History

- 1.0 (8.7.2020) - initial release
- 1.1 (9.7.2020) - added compressed archives