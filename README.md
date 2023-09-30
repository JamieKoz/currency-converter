# currency-converter

Currency conversion command in Symfony

## Assumptions

- The assumption that the value of money would be calculated and represented as
  floats
- Setting the value of the conversion rates in the config files. Ideally this
  would be configured in the .env. But as the values are arbitrarily set for
  this task they have been left in the config file.
- Normalise the currency type string to uppercase
- Store the conversion.csv file in the public directory

## How To

- `php bin/console currency:convert 100 aud usd`
- This command will output the converted currency values. The conversion.csv
  file with also be generated and placed into the public directory.

- `php bin/console calculate:profit`
- This command will read the .csv file if it exists and calculates the profit
  accordingly.
