# spid-php2

Software Development Kit (SDK) for easy SPID SSO integration based on [php-saml](https://github.com/onelogin/php-saml).

This component acts as a SPID SP (Service Provider) and logs you in via an external IDP (IDentity Provider). It does not support Attribute Authority.

Alternative SDK: [spid-php](https://github.com/italia/spid-php) based on [SimpleSAMLphp](https://simplesamlphp.org/).

## Features

|<img src="https://github.com/italia/spid-graphics/blob/master/spid-logos/spid-logo-c-lb.png?raw=true" width="100" /><br />_Compliance with [SPID regulations](http://www.agid.gov.it/sites/default/files/circolari/spid-regole_tecniche_v1.pdf) (for Service Providers)_|status| comments |
|:---|:---|:---|
|**Metadata:**||
|parsing of IdP XML metadata (1.2.2.4)|✓|currently you can configure a single IdP supplying its metedata url in the `idp_metadata_url` key of `config.yml`; the implementation of a workflow to configure the metadata for multiple IdPs is underway, see: #12; the implementation is not currently checking the AgID signature, see: #17 |
|parsing of AA XML metadata (2.2.4)| | Attribute Authority is unsupported |
|SP XML metadata generation (1.3.2)|✓| the SP metadata is made available at the `/metadata.php` endpoint; it is currently lacking the `AttributeConsumingService` (#18) and the optional `Organization` key (#19) |
|**AuthnRequest generation (1.2.2.1):**|||
|generation of AuthnRequest XML|✓| the generated AuthnRequest is not 100% compliant, see: #2 |
|HTTP-Redirect binding|✓| |
|HTTP-POST binding| ||
|`AssertionConsumerServiceURL` customization| | the PHP package we are using as a basis for this SDK ([onelogin/php-saml](https://github.com/onelogin/php-saml)) allows customization of the AuthnRequest, but we are not exposing yet this interface; this is tracked in: #21 |
|`AssertionConsumerServiceIndex` customization| | see: #21 |
|`AttributeConsumingServiceIndex` customization| | see: #21 |
|`AuthnContextClassRef` (SPID level) customization| | see: #21 |
|`RequestedAuthnContext/@Comparison` customization| |
|`RelayState` customization (1.2.2)| | the RelayState parameter is currently sent in clear, see: #20 |
|**Response/Assertion parsing**|||
|verification of `Response/Signature` value (if any)| | onelogin/php-saml can be configured to request a signed Response (`security.wantMessagesSigned` key) but we are not making use of it ATM, see: #23 |
|verification of `Response/Signature` certificate (if any) against IdP/<s>AA metadata</s>|✓| the underlying package checks the signature using the certificate found in the IdP metadata (see: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L369) |
|verification of `Assertion/Signature` value|✓| OK but strict mode must be set see: #22 |
|verification of `Assertion/Signature` certificate against IdP/<s>AA metadata</s>|✓| the underlying package checks the signature using the certificate found in the IdP metadata (see: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L369) |
|verification of `SubjectConfirmationData/@Recipient`|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L302 |
|verification of `SubjectConfirmationData/@NotOnOrAfter`|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L308 |
|verification of `SubjectConfirmationData/@InResponseTo`|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L296 |
|verification of `Issuer`|✓| the underlying package checks it:  https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L265 |
|verification of `Destination`|✓| the underlying package checks it:  https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L227 |
|verification of `Conditions/@NotBefore`|✓| the underlying package checks it:  https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L909 |
|verification of `Conditions/@NotOnOrAfter`|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L915 |
|verification of `Audience`|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L252 |
|parsing of Response with no `Assertion` (authentication/query failure)|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L783 |
|parsing of failure `StatusCode` (Requester/Responder)|✓| the underlying package checks it: https://github.com/onelogin/php-saml/blob/master/lib/Saml2/Response.php#L456 |
|verification of `RelayState` (saml-bindings-2.0-os 3.5.3)|✓| this is currently checked in the user code: https://github.com/simevo/spid-php2/blob/master/www2/index.php#L78 |
|**Response/Assertion parsing for SSO (1.2.1, 1.2.2.2, 1.3.1):**||
|parsing of `NameID`|?|
|parsing of `AuthnContextClassRef` (SPID level)|?|
|parsing of attributes|?|
|**Response/Assertion parsing for attribute query (2.2.2.2, 2.3.1):**||
|parsing of attributes|?|
|**LogoutRequest generation (for SP-initiated logout):**||
|generation of LogoutRequest XML|?|
|HTTP-Redirect binding|✓| |
|HTTP-POST binding| ||
|**LogoutResponse parsing (for SP-initiated logout):**||
|parsing of LogoutResponse XML|?|
|verification of `Response/Signature` value (if any)|?|
|verification of `Response/Signature` certificate (if any) against IdP metadata|?|
|verification of `Issuer`|?|
|verification of `Destination`|?|
|PartialLogout detection|?|
|**LogoutRequest parsing (for third-party-initiated logout):**||
|parsing of LogoutRequest XML|?|
|verification of `Response/Signature` value (if any)|?|
|verification of `Response/Signature` certificate (if any) against IdP metadata|?|
|verification of `Issuer`|?|
|verification of `Destination`|?|
|parsing of `NameID`|?|
|**LogoutResponse generation (for third-party-initiated logout):**||
|generation of LogoutResponse XML|?|
|HTTP-Redirect binding|?|
|HTTP-POST binding|?|
|PartialLogout customization|?|
|**AttributeQuery generation (2.2.2.1):**||
|generation of AttributeQuery XML|?|
|SOAP binding (client)|?|

## Prerequisites

Tested on Debian 10.x buster with PHP 7.2.

Perform these steps to install the prerequisites:
```
sudo apt install composer make openssl php-curl php-zip php-xml
```
if you have PHP <= 7.1 (i.e. Debian 9.4 stretch or earlier), then you also need:
```
apt install php-mcrypt
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

1. copy `config.yaml.example` to `config.yaml` and customize it as required (you should at least set `idp_metadata_url` to match your IDP metadata endpoint)

2. auto-configure:
    ```
    make
    ```

3. Start PHP's builtin webserver in the root of the repo:
    ```
    php -S localhost:8000 -t www
    ```
    if you have php-saml v2.x (i.e. Debian 9.4 stretch), then run it from the www2 dir:
    ```
    php -S localhost:8000 -t www2
    ```

4. visit http://localhost:8000/metadata.php to get the SP (Service Provider) metadata, then copy these over to the IDP

5. visit: http://localhost:8000 and click `login`.

## Troubleshooting

- install a browser plugin to trace SAML messages:

  - Firefox:

    - [SAML-tracer by Olav Morken, Jaime Perez](https://addons.mozilla.org/en-US/firefox/addon/saml-tracer/)
    - [SAML Message Decoder by Magnus Suther](https://addons.mozilla.org/en-US/firefox/addon/saml-message-decoder-extension/)

  - Chrome/Chromium:

    - [SAML Message Decoder by Magnus Suther](https://chrome.google.com/webstore/detail/saml-message-decoder/mpabchoaimgbdbbjjieoaeiibojelbhm)
    - [SAML Chrome Panel by MLai](https://chrome.google.com/webstore/detail/saml-chrome-panel/paijfdbeoenhembfhkhllainmocckace)
    - [SAML DevTools extension by stefan.rasmusson.as](https://chrome.google.com/webstore/detail/saml-devtools-extension/jndllhgbinhiiddokbeoeepbppdnhhio)

- use the [SAML Developer Tools](https://www.samltool.com/online_tools.php) provided by onelogin to understand what is going on

## Contributing

Your code **should** comply with the [PSR-2: Coding Style Guide](https://www.php-fig.org/psr/psr-2/).
Check your changes with:
```
./vendor/bin/phpcs --standard=PSR2 bin/configure.php
...
```

You **must** use the [git-flow workflow](https://danielkummer.github.io/git-flow-cheatsheet/).

## Legalese

Copyright (c) 2018, Paolo Greppi paolo.greppi@simevo.com

License: BSD 3-Clause, see [LICENSE](LICENSE) file.
