# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## UNRELEASED

### Changed

- CI completely moved from "Travis CI" to "Github Actions" _(travis builds disabled)_
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
