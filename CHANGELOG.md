# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## v3.0.3

### Fixed

- Global ruleset

## v3.0.2

### Fixed

- Rule for package `friendsofphp/php-cs-fixer`

## v3.0.1

### Fixed

- List of ignored file

## v3.0.0

### Added

- File cleaning configuration has been moved to `.clean_rules.php`
- Support for rules that exclude deletion of files and packages

### Changed

- Minimal require PHP version now is `8.2`
- Composer version up to `2.8`
- Package `phpstan/phpstan` up to `^1.12`
- Package `phpunit/phpunit` up to `^11.5`

## v2.7.0

### Added

- Checking for the type of package before cleanup. Not clean packages with the `metapackage` type

## v2.6.0

### Changed

- Version of `composer` in docker container updated up to `2.5.7`

### Fixed

- Expected type of installation path from composer installation manager [[#12](https://github.com/avto-dev/composer-cleanup-plugin/issues/12)]

## v2.5.1

### Fixed

- Rule for `dompdf/dompdf` package [[#10](https://github.com/avto-dev/composer-cleanup-plugin/issues/10)]

## v2.5.0

### Changed

- Minimal require PHP version now is `8.0`
- Minimal `composer-plugin-api` package  is `2.0`
- Minimal `phpstan` package  is `1.9`
- Version of `composer` in docker container updated up to `2.5.3`

## v2.4.0

### Changed

- Rules set updated

## v2.3.0

### Added

- Support PHP `8.x`

### Changed

- Composer `2.x` is supported now
- Minimal required PHP version now is `7.2`

## v2.2.0

### Changed

- Rules set updated
- Minimal package cleanup size changed from 16 to 32 KiB (for showing message `Cleanup done ...`)

## v2.1.0

### Changed

- Rules set updated

## v2.0.1

### Fixed

- Disabled all packages iteration for cleaning after **single** package installation or updating

### Added

- Plugin method `::cleanupAllPackages` for batch cleaning (can be executed manually using composer scripts, e.g.: `{"scripts": {"post-update-cmd": "AvtoDev\\Composer\\Cleanup\\Plugin::cleanupAllPackages"}}`)

### Changed

- Output messages format

## v2.0.0

### Changed

- Plugin totally rewrote

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
