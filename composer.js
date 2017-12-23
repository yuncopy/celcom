{
    "require": {
        "illuminate/database": "5.4.*",
        "illuminate/events": "5.4.*",
        "illuminate/pagination": "5.4.*",
        "monolog/monolog": "^1.23",
        "predis/predis": "1.1.*",
        "bramus/router": "~1.2",
        "twig/twig": "1.35.0",
        "php-curl-class/php-curl-class": "^8.0",
        "livecontrol/eloquent-datatable": "^0.1.5"
    },
    "autoload": {
        "psr-4":{
            "App\\": "app/",
            "Tests\\": "tests/"
        },
         "files":[
            "app/functions.php"
        ],
	"classmap": [
            "app/Library"
	]
    },
    "require-dev": {
        "filp/whoops": "^2.1",
        "symfony/var-dumper": "^3.3",
        "phpunit/phpunit": "5.7.*"
    }
}
