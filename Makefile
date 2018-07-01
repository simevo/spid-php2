all: sp.key
	mkdir -p tmp
	./bin/configure.php > www/settings.php

sp.key:
	openssl req -x509 -nodes -sha256 -days 365 -newkey rsa:2048 -subj "/C=IT/ST=Italy/L=Rome/O=testenv2/CN=localhost" -keyout sp.key -out sp.crt

clean:
	rm -rf tmp vendor www/settings.php
