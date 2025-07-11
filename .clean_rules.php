<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Get global packages cleanup rules.
    |--------------------------------------------------------------------------
    |
    | If you need to add files to the global list, it will be enough to override it
    | or create a Pull Request to the repository.
    |
    | Values can contains asterisk (`*` - zero or more characters).
    |
    */
    'global' => [
        '*.md', '*.MD', '*.rst', '*.RST', '*.markdown',
        // Markdown/reStructuredText files like `README.md`, `changelog.MD`..
        'AUTHORS', 'LICENSE', 'COPYING', 'AUTHORS', // Text files without extensions
        'CHANGES.txt', 'CHANGES', 'CHANGELOG.txt', 'LICENSE.txt', 'TODO.txt', 'README.txt', // Text files
        '.github', '.gitlab', '.git', // .git* specific directories
        '.gitignore', '.gitattributes', // git-specific files
        'phpunit.xml*', 'phpstan.neon*', 'phpbench.*', 'psalm.*', '.psalm', // Test configurations
        '.travis.yml', '.travis', '.scrutinizer.yml', '.circleci', 'appveyor.yml', // CI
        '.codecov.yml', '.coveralls.yml', '.styleci.yml', '.dependabot', // CI
        '.php_cs', '.php_cs.*', 'phpcs.*', '.*lint', // Code-style definitions
        '.gush.yml', 'bors.toml', '.pullapprove.yml', // 3rd party integrations
        '.editorconfig', '.idea', '.vscode', // Configuration for editors
        'phive.xml', 'build.xml', // Build configurations
        'composer.lock', // Composer lock file
        'Makefile', // Scripts, Makefile
        'Dockerfile', 'docker-compose.yml', 'docker-compose.yaml', '.dockerignore', // Docker
    ],

    /*
    |--------------------------------------------------------------------------
    | Rules for cleaning packages.
    |--------------------------------------------------------------------------
    |
    | Get packages cleanup rules as array, where key is package name, and value is an array of directories and/or
    | file names with extensions, which must be deleted.
    |
    | If you need to delete files from a specific directory, specify them as an array.
    |
    | Values can contains asterisk (`*` - zero or more characters).
    |
    */
    'packages' => [
        'afiqiqmal/huawei-push' => ['tests'],
        'anhskohbo/no-captcha' => ['tests'],
        'artesaos/seotools' => ['tests'],
        'aws/aws-sdk-php' => ['.changes', '.github'],
        'beyondcode/laravel-dump-server' => ['docs'],
        'binarytorch/larecipe' => ['package*', '*.js', 'yarn.lock'],
        'cakephp/chronos' => ['docs'],
        'cbschuld/browser.php' => ['tests'],
        'chumper/zipper' => ['tests'],
        'clue/stream-filter' => ['tests', 'examples'],
        'cogpowered/finediff' => ['tests'],
        'deployer/deployer' => ['docs'],
        'deployer/recipes' => ['docs'],
        'dnoegel/php-xdg-base-dir' => ['tests'],
        'doctrine/annotations' => ['docs'],
        'doctrine/inflector' => ['docs'],
        'doctrine/instantiator' => ['docs'],
        'dompdf/dompdf' => ['LICENSE.LGPL', 'VERSION'],
        'dragonmantank/cron-expression' => ['tests'],
        'elasticsearch/elasticsearch' => ['tests', 'travis', 'docs'],
        'erusev/parsedown-extra' => ['test'],
        'facade/ignition-contracts' => ['Tests', 'docs'],
        'fakerphp/faker' => [
            'test',
            'src/Faker/Provider' => [ // Lang support
                'el_GR', 'en_SG', 'fa_IR', 'ja_JP', 'mn_MN', 'pl_PL', 'vi_VN', 'zh_CN', 'sk_SK',
                'ar_JO', 'en_AU', 'en_UG', 'fi_FI', 'hu_HU', 'ka_GE', 'ms_MY', 'pt_BR', 'sr_RS',
                'ar_SA', 'cs_CZ', 'en_CA', 'hy_AM', 'kk_KZ', 'nb_NO', 'pt_PT', 'sv_SE', 'zh_TW',
                'at_AT', 'da_DK', 'en_ZA', 'fr_BE', 'id_ID', 'ko_KR', 'ne_NP', 'ro_MD', 'tr_TR',
                'en_HK', 'es_AR', 'fr_CA', 'nl_BE', 'ro_RO', 'th_TH', 'fr_CH', 'lt_LT', 'nl_NL',
                'de_AT', 'en_IN', 'es_ES', 'es_PE', 'fr_FR', 'is_IS', 'lv_LV', 'de_CH', 'en_NG',
                'bg_BG', 'de_DE', 'en_NZ', 'es_VE', 'he_IL', 'it_CH', 'me_ME', 'sl_SI', 'bn_BD',
                'el_CY', 'en_PH', 'et_EE', 'hr_HR', 'it_IT', 'uk_UA', 'sr_Cyrl_RS', 'sr_Latn_RS',
            ],
        ],
        'friendsofphp/php-cs-fixer' => ['.sh', '.md', '.png'],
        'google/apiclient' => ['docs'],
        'hackzilla/password-generator' => ['Tests'],
        'hamcrest/hamcrest-php' => ['tests'],
        'jakub-onderka/php-console-color' => ['tests'],
        'jakub-onderka/php-console-highlighter' => ['tests', 'examples'],
        'johnkary/phpunit-speedtrap' => ['tests'],
        'justinrainbow/json-schema' => ['demo'],
        'kalnoy/nestedset' => ['tests'],
        'kevinrob/guzzle-cache-middleware' => ['tests'],
        'kigkonsult/icalcreator' => ['docs'],
        'kwn/number-to-words' => ['tests'],
        'laravel/ui' => ['tests'],
        'lcobucci/jwt' => ['test'],
        'maennchen/zipstream-php' => ['test'],
        'markbaker/complex' => ['examples'],
        'markbaker/matrix' => ['examples'],
        'maxmind-db/reader' => ['ext\/tests', 'examples', 'tests'],
        'meyfa/php-svg' => ['tests'],
        'mockery/mockery' => ['tests', 'docker', 'docs'],
        'monolog/monolog' => ['tests'],
        'morrislaptop/laravel-queue-clear' => ['tests'],
        'mtdowling/jmespath.php' => ['tests'],
        'myclabs/deep-copy' => ['doc'],

        'nesbot/carbon' => [
            '~src/Carbon/Lang/(?!(en|ru|uk)\.).*?\.php~i',
        ],
        'nikic/php-parser' => ['test', 'test_old', 'doc'],
        'opekunov/laravel-centrifugo-broadcaster' => ['tests'],
        'paragonie/random_compat' => ['other', '*.sh'],
        'paragonie/sodium_compat' => ['*.sh', 'plasm-*.*', 'dist'],
        'pear/archive_tar' => ['docs', 'tests', 'sync-php4'],
        'pear/cache_lite' => ['docs', 'tests', 'TODO'],
        'pear/console_getopt' => ['Console\/tests'],
        'pear/mime_type' => ['docs', 'tests'],
        'pear/structures_graph' => ['docs', 'tests'],
        'phar-io/manifest' => ['tests', 'examples', 'xsd'],
        'phar-io/version' => ['tests'],
        'phenx/php-font-lib' => ['tests'],
        'phenx/php-svg-lib' => ['tests', 'COPYING.GPL'],
        'phpstan/phpdoc-parser' => ['doc'],
        'phpunit/php-code-coverage' => ['tests'],
        'phpunit/php-file-iterator' => ['tests'],
        'phpunit/php-invoker' => ['tests'],
        'phpunit/php-timer' => ['tests'],
        'phpunit/php-token-stream' => ['tests'],
        'phpunit/phpunit' => ['tests'],
        'phpunit/phpunit-selenium' => ['Tests', 'selenium-1-tests'],
        'predis/predis' => ['examples'],
        'proj4php/proj4php' => ['test'],
        'psr/log' => ['Psr\/Log\/Test'],
        'psy/psysh' => ['.phan', 'test', 'vendor-bin'],
        'queue-interop/amqp-interop' => ['tests'],
        'queue-interop/queue-interop' => ['tests'],
        'ralouphie/getallheaders' => ['tests'],
        'rap2hpoutre/laravel-log-viewer' => ['tests'],
        'react/promise' => ['tests'],
        'rmccue/requests' => ['tests', 'docs', 'examples'],
        'sabberworm/php-css-parser' => ['tests'],
        'schuppo/password-strength' => ['tests'],
        'sebastian/code-unit' => ['tests'],
        'sebastian/code-unit-reverse-lookup' => ['tests'],
        'sebastian/comparator' => ['tests'],
        'sebastian/diff' => ['tests'],
        'sebastian/environment' => ['tests'],
        'sebastian/exporter' => ['tests'],
        'sebastian/global-state' => ['tests'],
        'sebastian/object-enumerator' => ['tests'],
        'sebastian/object-reflector' => ['tests'],
        'sebastian/recursion-context' => ['tests'],
        'sebastian/resource-operations' => ['tests', 'build'],
        'sebastian/type' => ['tests'],
        'sentry/sentry-laravel' => ['test', 'scripts', '.craft.yml'],
        'spatie/laravel-permission' => ['art', 'docs'],
        'spiral/goridge' => ['examples', '*.go', 'go.mod', 'go.sum'],
        'spiral/roadrunner' => ['cmd', 'osutil', 'service', 'util', 'systemd', '*.mod', '*.sum', '*.go', '*.sh', 'tests'],
        'stil/gd-text' => ['examples', 'tests'],
        'swiftmailer/swiftmailer' => ['tests', 'doc'],
        'symfony/console' => ['Tester'],
        'symfony/css-selector' => ['Tests'],
        'symfony/debug' => ['Tests'],
        'symfony/event-dispatcher' => ['Tests'],
        'symfony/filesystem' => ['Tests'],
        'symfony/finder' => ['Tests'],
        'symfony/http-foundation' => ['Tests'],
        'symfony/http-kernel' => ['Tests'],
        'symfony/options-resolver' => ['Tests'],
        'symfony/psr-http-message-bridge' => ['Tests'],
        'symfony/routing' => ['Tests'],
        'symfony/service-contracts' => ['Test'],
        'symfony/stopwatch' => ['Tests'],
        'symfony/translation' => ['Tests'],
        'symfony/translation-contracts' => ['Test'],
        'symfony/var-dumper' => ['Tests', 'Test'],
        'tecnickcom/tcpdf' => ['doc', 'examples', '*.TXT'],
        'theiconic/php-ga-measurement-protocol' => ['tests', 'docs'],
        'theseer/tokenizer' => ['tests'],

        'unisharp/laravel-filemanager' => [
            'tests',
            'docs',
            'src/lang' => [
                'ar', 'az', 'bg', 'de', 'el', 'eu', 'fa', 'fr', 'he', 'hu', 'id', 'it', 'ka',
                'nl', 'pl', 'pt', 'pt-BR', 'ro', 'rs', 'sv', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW',
            ],
        ],
        'voku/portable-ascii' => ['docs'],
        'wapmorgan/morphos' => ['tests', '*.md'],
        'yoomoney/yookassa-sdk-php' => ['tests', '*.md'],
    ],

    /*
    |--------------------------------------------------------------------------
    | List for excluded rules.
    |--------------------------------------------------------------------------
    |
    | Specify items to exclude from the list of global rules or packages,
    | maintaining an array structure where the key is the package name and the value is
    | an array of directories and/or file names with extensions to be removed.
    |
    | If you need to specify files from a specific directory, specify them as an array.
    |
    | Values can contains asterisk (`*` - zero or more characters).
    |
    | Example for global rules:
    | 'excluded_global' => [
    |   'composer.lock
    | ],
    |
    | Example for package rules:
    | 'excluded_packages' => [
    |   'namespace/package' => [
    |     'CHANGELOG.md'
    |    ]
    | ]
    |
    */
    'excluded_global' => [],
    'excluded_packages' => [],
];
