all: sp.key AuthnRequest.patched LogoutRequest.patched

AuthnRequest.patched: AuthnRequest.diff
	if [ -e $@ ]; then patch -R vendor/onelogin/php-saml/lib/Saml2/AuthnRequest.php $@; fi
	  patch -N vendor/onelogin/php-saml/lib/Saml2/AuthnRequest.php $<
	cp AuthnRequest.diff $@

LogoutRequest.patched: LogoutRequest.diff
	if [ -e $@ ]; then patch -R vendor/onelogin/php-saml/lib/Saml2/LogoutRequest.php $@; fi
	   patch -N vendor/onelogin/php-saml/lib/Saml2/LogoutRequest.php $<
	cp LogoutRequest.diff $@

sp.key:
	openssl req -x509 -nodes -sha256 -days 365 -newkey rsa:2048 -subj "/C=IT/ST=Italy/L=Rome/O=testenv2/CN=localhost" -keyout sp.key -out sp.crt

clean:
	rm -rf vendor
