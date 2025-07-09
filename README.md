<p align="center">
  <img alt="logo" src="https://hsto.org/webt/qm/vw/f1/qmvwf1kh3qymvadnet4ggvt_pue.png" height="160" />
</p>

# Composer Cleanup Plugin

[![Version][badge_packagist_version]][link_packagist]
[![Version][badge_php_version]][link_packagist]
[![Build Status][badge_build]][link_build]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

Remove tests & documentation from the vendor dir. Based on [barryvdh/composer-cleanup-plugin](https://github.com/barryvdh/composer-cleanup-plugin).

Usually disk size shouldn't be a problem, but when you have to use FTP to deploy or have very limited disk space, you can use this package to cut down the vendor directory by deleting files that aren't used in production (tests/docs etc).

> **Note:** This package is still experimental, usage in production without detailed tests is not recommended.

## Install

Require this package in your composer.json:

```bash
$ composer require avto-dev/composer-cleanup-plugin "^2.0"
```

## Usage

If you are using `composer:v1` you need to add lines to run the clean command after each package is installed:

```json
"post-package-install": [
    "AvtoDev\\Composer\\Cleanup\\Plugin::handlePostPackageInstallEvent"
],
```

If you use `composer:v2` then all packages are installed in parallel, so automatic cleanup occurs after all packages are installed and the event fires `POST_AUTOLOAD_DUMP`.


## What does it do?

For every installed or updated package in the default list, in general:

1. Remove documentation, such as README files, docs folders, etc.
2. Remove tests, PHPUnit configs, and other build/CI configuration.

Some packages don't obey the general rules, and remove more/less files. Packages that do not have rules added are ignored.

## Rules

Please submit a PR to [src/.clean_rules.php] to add more rules for packages. Make sure you test them first, sometimes tests dirs are classmapped and will error when deleted.

If you need to optionally override the parameters of the cleaning rules, then create a `.clean_rules.php` file in the root of your application that returns an associated array of rules.
If it exists, its content will be merged with the package config, optionally overriding the necessary rules.
The config includes 4 properties: `global`, `packages`, `excluded_global`, `excluded_packages`.

#### Global

List of files ready for removal in each installed package.


#### Packages

List of files and directories ready for deletion by package.

#### Excluded global

List of files that should be excluded from the deletion list.

#### Excluded Packages

List of files and directories to exclude from deletion on a per-package basis.

### Full example

It should look like this:

```php
<?php

return [
    'global' => [
        'test.yml', // Delete file `test.yml` from all packages
        'ci.yaml',
        'stub.json',
    ],

    'packages' => [
        'company/first-package' => ['tests'], // Delete all matches in package
        'company/second-package' => ['test', '*.md'],
        'company/third-package' => ['docs'],
    ],

    'excluded_global' => [
        'stub.json', // This file will be excluded from global list
    ],
    'excluded_packages' => [
        'company/first-package' => ['tests/ApiTest.php'], // This file will not be deleted
        'company/third-package' => null, // This package will be excluded from the purge list.
    ],
];

```

### Testing

For package testing we use `phpunit` framework and `docker-ce` + `docker-compose` as develop environment. So, just write into your terminal after repository cloning:

```shell
$ make build
$ make latest # or 'make lowest'
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avto-dev/composer-cleanup-plugin.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avto-dev/composer-cleanup-plugin.svg?longCache=true
[badge_build]:https://img.shields.io/github/actions/workflow/status/avto-dev/composer-cleanup-plugin/tests.yml
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/composer-cleanup-plugin/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/composer-cleanup-plugin.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/composer-cleanup-plugin.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/composer-cleanup-plugin.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/composer-cleanup-plugin/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/composer-cleanup-plugin.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/composer-cleanup-plugin.svg?style=flat-square&maxAge=180

[link_releases]:https://github.com/avto-dev/composer-cleanup-plugin/releases
[link_packagist]:https://packagist.org/packages/avto-dev/composer-cleanup-plugin
[link_build]:https://github.com/avto-dev/composer-cleanup-plugin/actions
[link_coverage]:https://codecov.io/gh/avto-dev/composer-cleanup-plugin/
[link_changes_log]:https://github.com/avto-dev/composer-cleanup-plugin/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avto-dev/composer-cleanup-plugin/issues
[link_create_issue]:https://github.com/avto-dev/composer-cleanup-plugin/issues/new/choose
[link_commits]:https://github.com/avto-dev/composer-cleanup-plugin/commits
[link_pulls]:https://github.com/avto-dev/composer-cleanup-plugin/pulls
[link_license]:https://github.com/avto-dev/composer-cleanup-plugin/blob/master/LICENSE
[src/.clean_rules.php]:/.clean_rules.php
