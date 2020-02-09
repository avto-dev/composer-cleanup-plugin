<?php

declare(strict_types = 1);

namespace AvtoDev\Composer\Cleanup;

class Rules
{
    /**
     * Get global packages cleanup rules.
     *
     * Values can contains asterisk (`*` - zero or more characters) and question mark (`?` - exactly one character).
     *
     * @see <https://www.php.net/manual/en/function.glob.php#refsect1-function.glob-parameters>
     *
     * @return array<string>
     */
    public static function getGlobalRules(): array
    {
        return [
            '*.md', '*.MD', '*.rst', '*.RST', // Markdown/reStructuredText files like `README.md`, `changelog.MD`..
            'AUTHORS', 'LICENSE', // Text files without extensions
            '.github', '.gitlab', // .git* specific directories
            '.gitignore', '.gitattributes', // git-specific files
            'phpunit.xml*', 'phpstan.neon*', 'phpbench.*', 'psalm.*', // Test configurations
            '.travis.yml', '.travis', '.scrutinizer.yml', '.circleci', 'appveyor.yml', // CI
            '.codecov.yml', '.coveralls.yml', '.styleci.yml', // CI
            '.php_cs', '.php_cs.*', 'phpcs.*', '.*lint', // Code-style definitions
            '.gush.yml', // 3rd party integrations
            '.editorconfig', '.idea', '.vscode', // Configuration for editors
            'phive.xml', 'build.xml', // Build configurations
            'composer.lock', // Composer lock file
            'Makefile' // Scripts, Makefile
        ];
    }

    /**
     * Get packages cleanup rules as array, where key is package name, and value is an array of directories and/or
     * file names, which must be deleted.
     *
     * Values can contains asterisk (`*` - zero or more characters) and question mark (`?` - exactly one character).
     *
     * @see <https://www.php.net/manual/en/function.glob.php#refsect1-function.glob-parameters>
     *
     * @return array<string, array<string>>
     */
    public static function getPackageRules(): array
    {
        return [
            'aws/aws-sdk-php'                       => ['src/data'], // Note: Can be dangerous!
            'binarytorch/larecipe'                  => ['package*', '*.js', 'yarn.lock'],
            'clue/stream-filter'                    => ['tests', 'examples'],
            'dragonmantank/cron-expression'         => ['tests'],
            'erusev/parsedown-extra'                => ['test'],
            'friendsofphp/php-cs-fixer'             => ['*.sh'], // Note: `tests` must be not included
            'fzaninotto/faker'                      => self::getFzaninottoFakerRules(),
            'hamcrest/hamcrest-php'                 => ['tests'],
            'jakub-onderka/php-console-color'       => ['tests'],
            'jakub-onderka/php-console-highlighter' => ['tests', 'examples'],
            'johnkary/phpunit-speedtrap'            => ['tests'],
            'justinrainbow/json-schema'             => ['demo'],
            'kevinrob/guzzle-cache-middleware'      => ['tests'],
            'mockery/mockery'                       => ['tests', 'docker', 'docs'],
            'mtdowling/jmespath.php'                => ['tests'],
            'nesbot/carbon'                         => self::getNesbotCarbonRules(),
            'paragonie/random_compat'               => ['other', '*.sh'],
            'paragonie/sodium_compat'               => ['*.sh', 'plasm-*.*', 'dist'],
            'phar-io/manifest'                      => ['tests', 'examples'],
            'phar-io/version'                       => ['tests'],
            'phpunit/php-code-coverage'             => ['tests'],
            'phpunit/php-file-iterator'             => ['tests'],
            'phpunit/php-timer'                     => ['tests'],
            'phpunit/php-token-stream'              => ['tests'],
            'phpunit/phpunit'                       => ['tests'],
            'psy/psysh'                             => ['.phan', 'test', 'vendor-bin'],
            'queue-interop/amqp-interop'            => ['tests'],
            'queue-interop/queue-interop'           => ['tests'],
            'sebastian/code-unit-reverse-lookup'    => ['tests'],
            'sebastian/comparator'                  => ['tests'],
            'sebastian/diff'                        => ['tests'],
            'sebastian/environment'                 => ['tests'],
            'sebastian/exporter'                    => ['tests'],
            'sebastian/object-enumerator'           => ['tests'],
            'sebastian/object-reflector'            => ['tests'],
            'sebastian/recursion-context'           => ['tests'],
            'sebastian/resource-operations'         => ['tests'],
            'sentry/sentry-laravel'                 => ['test', 'scripts', '.craft.yml'],
            'spiral/goridge'                        => ['examples', '*.go', 'go.mod', 'go.sum'],
            'spiral/roadrunner'                     => [
                'cmd', 'osutil', 'service', 'util', '*.mod', '*.sum', '*.go', '*.sh',
            ],
            'swiftmailer/swiftmailer'               => ['tests'],
            'symfony/psr-http-message-bridge'       => ['Tests'],
            'symfony/service-contracts'             => ['Test'],
            'symfony/translation'                   => ['Tests'],
            'symfony/translation-contracts'         => ['Test'],
            'symfony/var-dumper'                    => ['Tests', 'Test'],
            'theseer/tokenizer'                     => ['tests'],
        ];
    }

    /**
     * @return array<string>
     */
    protected static function getFzaninottoFakerRules(): array
    {
        return \array_map(static function (string $locale): string {
            return "src/Faker/Provider/{$locale}";
        }, [
            'el_GR', 'en_SG', 'fa_IR', 'ja_JP', 'mn_MN', 'pl_PL', 'vi_VN', 'zh_CN', 'sk_SK',
            'ar_JO', 'en_AU', 'en_UG', 'fi_FI', 'hu_HU', 'ka_GE', 'ms_MY', 'pt_BR', 'sr_RS',
            'ar_SA', 'cs_CZ', 'en_CA', 'hy_AM', 'kk_KZ', 'nb_NO', 'pt_PT', 'sv_SE', 'zh_TW',
            'at_AT', 'da_DK', 'en_ZA', 'fr_BE', 'id_ID', 'ko_KR', 'ne_NP', 'ro_MD', 'tr_TR',
            'en_HK', 'es_AR', 'fr_CA', 'nl_BE', 'ro_RO', 'th_TH', 'fr_CH', 'lt_LT', 'nl_NL',
            'de_AT', 'en_IN', 'es_ES', 'es_PE', 'fr_FR', 'is_IS', 'lv_LV', 'de_CH', 'en_NG',
            'bg_BG', 'de_DE', 'en_NZ', 'es_VE', 'he_IL', 'it_CH', 'me_ME', 'sl_SI', 'bn_BD',
            'el_CY', 'en_PH', 'et_EE', 'hr_HR', 'it_IT', 'uk_UA', 'sr_Cyrl_RS', 'sr_Latn_RS',
        ]);
    }

    /**
     * @return array<string>
     */
    protected static function getNesbotCarbonRules(): array
    {
        return \array_map(static function (string $locale): string {
            return "src/Carbon/Lang/{$locale}.php";
        }, [
            'a?*_*', 'a?', 'a??',
            'b?*_*', 'b?', 'b??',
            'c?*_*', 'c?', 'c??',
            'd?*_*', 'd?', 'd??',
            'e[bel]_*', 'en_[01ABCDEFHIJKLMN]*', 'en_G[DGHIMUY]*', 'e[belostw]?', 'e[stw]_*', 'en_[PRSTUVWZ]?', 'e[elnost]',
            'f?*_*', 'f?', 'f??',
            'g?*_*', 'g?', 'g??',
            'h?*_*', 'h?', 'h??',
            'i?*_*', 'i?', 'i??',
            'j?*_*', 'j?', 'j??',
            'k?*_*', 'k?', 'k??',
            'l?*_*', 'l?', 'l??',
            'm?*_*', 'm?', 'm??',
            'n?*_*', 'n?', 'n??',
            'o?*_*', 'o?', 'o??',
            'p?*_*', 'p?', 'p??',
            'q?*_*', 'q?', 'q??',
            'r[ow]?_*', 'r[amnojw]*',
            's?*_*', 's?', 's??',
            't?*_*', 't?', 't??',
            'u[gznrz]*',
            'v?*_*', 'v?', 'v??',
            'w?*_*', 'w?', 'w??',
            'x?*_*', 'x?', 'x??',
            'y?*_*', 'y?', 'y??',
            'z?*_*', 'z?', 'z??',
        ]);
    }
}
