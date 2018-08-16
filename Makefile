all: example/sp.key AuthnRequest.patched LogoutRequest.patched Metadata.patched

AuthnRequest.patched: TO_PATCH:=vendor/onelogin/php-saml/src/Saml2/AuthnRequest.php
AuthnRequest.patched: AuthnRequest.diff
	if [ -e $@ ]; then patch -R vendor/onelogin/php-saml/src/Saml2/AuthnRequest.php $@; fi
	  patch -N vendor/onelogin/php-saml/src/Saml2/AuthnRequest.php $<
	cp AuthnRequest.diff $@

LogoutRequest.patched: TO_PATCH=vendor/onelogin/php-saml/src/Saml2/LogoutRequest.php
LogoutRequest.patched: LogoutRequest.diff
	if [ -e $@ ]; then patch -R vendor/onelogin/php-saml/src/Saml2/LogoutRequest.php $@; fi
	   patch -N vendor/onelogin/php-saml/src/Saml2/LogoutRequest.php $<
	cp LogoutRequest.diff $@

Metadata.patched: TO_PATCH=vendor/onelogin/php-saml/src/Saml2/Metadata.php
Metadata.patched: Metadata.diff
	if [ -e $@ ]; then patch -R vendor/onelogin/php-saml/src/Saml2/Metadata.php $@; fi
	   patch -N vendor/onelogin/php-saml/src/Saml2/Metadata.php $<
	cp Metadata.diff $@

example/sp.key:
	openssl req -x509 -nodes -sha256 -days 365 -newkey rsa:2048 -subj "/C=IT/ST=Italy/L=Rome/O=testenv2/CN=localhost" -keyout example/sp.key -out example/sp.crt

clean:
	rm -rf vendor
	rm -f AuthnRequest.patched
	rm -f LogoutRequest.patched
	rm -f Metadata.patched
	rm -f example/idp_metadata/*.xml
	rm -f example/sp.crt example/sp.key
