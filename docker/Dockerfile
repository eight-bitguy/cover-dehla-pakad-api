FROM alpine:3.11.3

RUN apk --no-cache add \
  php7 php7-opcache php7-fpm php7-cgi php7-ctype php7-json php7-dom php7-zip php7-zip php7-gd php7-curl php7-mbstring \
  php7-redis php7-mcrypt php7-posix php7-pdo_mysql php7-tokenizer php7-simplexml php7-session php7-xml php7-sockets \
  php7-openssl php7-fileinfo php7-ldap php7-exif php7-pcntl php7-xmlwriter php7-phar php7-zlib php7-intl php7-gmp

RUN apk --no-cache add git bash curl

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
  php composer-setup.php && \
  php -r "unlink('composer-setup.php');" && \
  mv composer.phar /usr/local/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install

ADD /docker/bin/php.ini /etc/php7/php.ini

ADD ./docker/bin/www.conf /etc/php7/php-fpm.d/www.conf
