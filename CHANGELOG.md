# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

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
