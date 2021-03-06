# Collection

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what
PSRs you support to avoid any confusion with users and contributors.

## Install

Via Composer

``` bash
$ IN PROGRESS
```

## Usage

``` php
$collection = new Collection([1,2,3,4,5,6,7,8,9,10]);

$filteredCollection = $this->collection->filter(function ($item)
{
    return $item % 2 == 0;
});
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Credits

- [HIXMAN][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/HIXMAN/Collection.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/HIXMAN/Collection/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/HIXMAN/Collection.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/HIXMAN/Collection.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/HIXMAN/Collection.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/HIXMAN/Collection
[link-travis]: https://travis-ci.org/HIXMAN/Collection
[link-scrutinizer]: https://scrutinizer-ci.com/g/HIXMAN/Collection/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/HIXMAN/Collection
[link-downloads]: https://packagist.org/packages/HIXMAN/Collection
[link-author]: https://github.com/HIXMAN
[link-contributors]: ../../contributors
