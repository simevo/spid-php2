all: sp.key AuthnRequest.patched
	# clean up twig cache
	rm -rf tmp
	mkdir -p tmp
	./bin/configure.php > www/settings.php
	cp www/settings.php www2/settings.php

AuthnRequest.patched: AuthnRequest.diff
	if [ -e $@ ]; then patch -R vendor/onelogin/php-saml/lib/Saml2/AuthnRequest.php $@; fi
	  patch -N vendor/onelogin/php-saml/lib/Saml2/AuthnRequest.php $<
	cp AuthnRequest.diff $@

sp.key:
	openssl req -x509 -nodes -sha256 -days 365 -newkey rsa:2048 -subj "/C=IT/ST=Italy/L=Rome/O=testenv2/CN=localhost" -keyout sp.key -out sp.crt

clean:
	rm -rf tmp vendor www/settings.php
