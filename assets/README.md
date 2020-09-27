# MixerAPI {PLUGIN_NAME}

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/{PACKAGE}.svg?style=flat-square)](https://packagist.org/packages/mixerapi/{PACKAGE})
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.txt)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)
<!--- [![Build Status]()]() [![Coverage Status]()]() --->

## Installation 

```bash
composer require mixerapi/{PACKAGE}
bin/cake plugin load MixerApi/{PLUGIN_NAME}
```

Alternatively after composer installing you can manually load the plugin in your Application:

```php
# src/Application.php
public function bootstrap(): void
{
    // other logic...
    $this->addPlugin('MixerApi/{PLUGIN_NAME}');
}
```

## Unit Tests

```bash
vendor/bin/phpunit
```

## Code Standards

```bash
composer check
```