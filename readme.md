# SAW (Simple Additive Weighting) Decision Support Engine

SAW is an implementation of a Decision Support Engine (DSE) to perform analysis and decision-making based on the Simple Additive Weighting method.

## Installation

You can install this library via Composer. Run the following command in your terminal:

```bash
composer require donyahmd/dss-lib
```

## Usage

Here is an example of using the SAW class:

```php
<?php

use Donyahmd\DssLib\SAW;

// Define criteria and alternative data
$criteria = [
    // Criteria definition
];

$alternativeData = [
    // Alternative data
];

// Create an instance of SAW with criteria and alternative data
$saw = new SAW($criteria, $alternativeData);

// Perform classification
$saw->classification();

// Perform normalization
$saw->normalization();

// Perform criteria weighting
$saw->criteriaWeighting();

// Calculate the total weighting per alternative
$saw->totalWeightingPerAlternative();

// Perform ranking
$saw->ranking();

// Get the ranking result
$rankingResult = $saw->result();

// Display the result
print_r($rankingResult);
```

## Contributing

If you find any issues or would like to contribute, please feel free to create an issue or submit a pull request.

## License

This project is licensed under the MIT License. See the LICENSE file for more information.
