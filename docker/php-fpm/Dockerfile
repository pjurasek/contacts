FROM php:8.1.10-fpm

ARG HOST_USERNAME
ARG HOST_UID
ARG HOST_GID

ADD docker-prompt /etc/bash.colorprompt
RUN echo '. /etc/bash.colorprompt' >> /etc/bash.bashrc\
     && echo '. /etc/bash.colorprompt' >> /root/.bashrc

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu && \
    pecl install xdebug && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo pdo_mysql && \
    docker-php-ext-enable apcu pdo pdo_mysql sodium xdebug && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY conf.d/90-xdebug.ini "${PHP_INI_DIR}/conf.d"

# Create system user to run Composer and Migrations commands
RUN useradd -G www-data,root -u ${HOST_UID} -d /home/${HOST_USERNAME} ${HOST_USERNAME}
RUN mkdir -p /home/${HOST_USERNAME}/.composer && \
    chown -R ${HOST_USERNAME}:${HOST_USERNAME} /home/${HOST_USERNAME}

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o ; wait-for-it service-mariadb:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm

EXPOSE 9000

# Change to the new user
USER ${HOST_USERNAME}
