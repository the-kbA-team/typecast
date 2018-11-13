# Typecast

[![License: MIT][license-mit]](LICENSE)
[![Build Status][build-status-master]][travis-ci]
[![Maintainability][maintainability-badge]][maintainability]
[![Test Coverage][coverage-badge]][coverage]

Cast any given data structure into any desired format.

## Installation

```
composer install kba-team/typecast:dev-master
```

## Usage

```php
<?php
use kbATeam\TypeCast\TypeCastArray;
use \kbATeam\TypeCast\TypeCastValue;

//prepare typecast rules
$cast = new TypeCastArray();
$cast['myIntValue'] = new TypeCastValue('integer');
$cast['myFloatValues'] = new TypeCastArray();
$cast['myFloatValues'][0] = new TypeCastValue('float');
$cast['mySettings'] = new TypeCastArray();
$cast['mySettings']['a'] = new TypeCastValue('boolean');
$cast['mySettings']['b'] = new TypeCastValue('boolean');

//the raw data array
$raw_data = [
    'myIntValue' => ' 123    ',
    'myFloatValues' => [
        '  3.00',
        '  4.50'
    ],
    'mySettings' => [
        'a' => '0',
        'b' => '1'
    ]
];

//cast the raw data
$data = $cast($raw_data);

echo serialize($data);
/* Output:
a:3:{s:10:"myIntValue";i:123;s:13:"myFloatValues";a:2:{i:0;d:3;i:1;d:4.5;}s:10:"mySettings";a:2:{s:1:"a";b:0;s:1:"b";b:1;}}
 */
```

[license-mit]: https://img.shields.io/badge/license-MIT-blue.svg
[travis-ci]: https://travis-ci.org/the-kbA-team/typecast
[build-status-master]: https://api.travis-ci.org/the-kbA-team/typecast.svg?branch=master
[maintainability-badge]: https://api.codeclimate.com/v1/badges/8e1a6f3bf601d757a4a3/maintainability
[maintainability]: https://codeclimate.com/github/the-kbA-team/typecast/maintainability
[coverage-badge]: https://api.codeclimate.com/v1/badges/8e1a6f3bf601d757a4a3/test_coverage
[coverage]: https://codeclimate.com/github/the-kbA-team/typecast/test_coverage
