# MixerApi Plugin Template

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mixerapi/plugin.svg?style=flat-square)](https://packagist.org/packages/mixerapi/plugin)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE.txt)
[![MixerApi](https://mixerapi.com/assets/img/mixer-api-red.svg)](http://mixerapi.com)
[![CakePHP](https://img.shields.io/badge/cakephp-%3E%3D%204.0-red?logo=cakephp)](https://book.cakephp.org/4/en/index.html)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.2-8892BF.svg?logo=php)](https://php.net/)

A skeleton for creating standalone plugins in CakePHP `4.x`. While this plugin is geared towards building MixerAPI 
project plugins, you can use this for your own projects or fork and change what you need.

## Usage

```bash
composer create-project -s dev --prefer-dist mixerapi/plugin {plugin-name}
```

## Features

- Creates a MixerAPI themed `README.md`
- Defines PHPStan, PHPMD, and PHPCS rules
- Updates namespaces in `src/Plugin.php` and in `composer.json`