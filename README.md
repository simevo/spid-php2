# spid-php2

Software Development Kit (SDK) for easy SPID SSO inegration based on [php-saml](https://github.com/onelogin/php-saml).

This component acts as a SPID SP (Service Provider) and logs you in via an external IDP (IDentity Provider).

Alternative SDK: [spid-php](https://github.com/italia/spid-php) based on [SimpleSAMLphp](https://simplesamlphp.org/).

## Prerequisites

Tested on Debian 10.x buster with PHP 7.2.

Perform these steps to install the prerequisites:
```
sudo apt install composer make
```

Then install PHP dependencies; if you have PHP 7.2 (i.e. Debian 10.x buster):
```
composer install
```
if you have PHP <= 7.1 (i.e. Debian 9.4 stretch or earlier), then use the v2.x branch of php-saml:
```
rm composer.*
composer require onelogin/php-saml
composer require twig/twig
composer require symfony/yaml
```

## Demo

The demo is based on php-saml demo1.

To set it up and run it:

1. Start PHP's builtin webserver in the root of the repo:
    ```
    php -S localhost:8000 -t www
    ```

2. copy `config.yaml.example` to `config.yaml` and customize it as required (you should at least set `idp_metadata_url` to match your IDP metadata endpoint)

3. autoconfigure:
    ```
    make
    ```

4. visit http://localhost:8000/metadata.php to get the SP (Service Provider) metadata, then copy these over to the IDP

5. visit: http://localhost:8000 and click `login`.

## Contributing

Your code **should** comply with the [PSR-2: Coding Style Guide](https://www.php-fig.org/psr/psr-2/).
Check your changes with:
```
./vendor/bin/phpcs --standard=PSR2 bin/configure.php
...
```

You **must** use the [gitflow workflow](https://danielkummer.github.io/git-flow-cheatsheet/).

## Legalese

Copyright (c) 2018, Paolo Greppi paolo.greppi@simevo.com

License: BSD 3-Clause, see [LICENSE](LICENSE) file.
