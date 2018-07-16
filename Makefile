all: sp.key
	# clean up twig cache
	rm -rf tmp
	mkdir -p tmp
	./bin/configure.php > www/settings.php
	cp www/settings.php www2/settings.php
	mkdir -p www/dev
	mkdir -p www/src
	mkdir -p www2/dev
	mkdir -p www2/src
	rm -f www/src/data www2/src/data www/img www2/img
	ln -s ../../node_modules/spid-smart-button/src/data www/src/data
	ln -s ../node_modules/spid-smart-button/img www/img
	ln -s ../../node_modules/spid-smart-button/src/data www2/src/data
	ln -s ../node_modules/spid-smart-button/img www2/img
	sass node_modules/spid-smart-button/src/scss/agid-spid-enter-dev.scss | tee www2/dev/agid-spid-enter.min.css > www/dev/agid-spid-enter.min.css
	uglifyjs node_modules/spid-smart-button/src/js/agid-spid-enter.js node_modules/spid-smart-button/src/js/agid-spid-enter-tpl.js node_modules/spid-smart-button/src/js/agid-spid-enter-config-dev.js -b | tee www2/dev/agid-spid-enter.min.js > www/dev/agid-spid-enter.min.js


sp.key:
	openssl req -x509 -nodes -sha256 -days 365 -newkey rsa:2048 -subj "/C=IT/ST=Italy/L=Rome/O=testenv2/CN=localhost" -keyout sp.key -out sp.crt

clean:
	rm -rf tmp vendor www/settings.php
