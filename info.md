1. app/common/params.php и  указать домен для печенек
2. app/common/params-local.php указать cookieValidationKey
3. установка мемкеша sudo apt install php7.1-memcached memcached
memcached - сервер, php7.1-memcached - библиотека php 
(альтернатива php7.1-memcached, более простая библиотека) 
4. В common/main подключить мемкэш 