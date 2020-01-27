# Typecast

[![License: MIT][license-mit]](LICENSE)
[![Build Status][build-status-php5]][travis-ci]

Typecast the values of any given data structure.

## Installation

```
composer install kba-team/typecast
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
[build-status-php5]: https://api.travis-ci.org/the-kbA-team/typecast.svg?branch=php5
