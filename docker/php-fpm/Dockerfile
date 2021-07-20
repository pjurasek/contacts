FROM php:8.0.8-fpm

ARG CUSTOM_USER_NAME
ARG CUSTOM_UID
ARG CUSTOM_GID

ADD docker-prompt /etc/bash.colorprompt
RUN echo '. /etc/bash.colorprompt' >> /etc/bash.bashrc\
     && echo '. /etc/bash.colorprompt' >> /root/.bashrc

COPY wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apt-get update && \
    apt-get install -y --no-install-recommends libssl-dev zlib1g-dev curl git unzip netcat libxml2-dev libpq-dev libzip-dev && \
    pecl install apcu && \
    docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && \
    docker-php-ext-install -j$(nproc) zip opcache intl pdo_pgsql pgsql && \
    docker-php-ext-enable apcu pdo_pgsql sodium && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Create system user to run Composer and Migrations commands
RUN useradd -G www-data,root -u ${CUSTOM_UID} -d /home/${CUSTOM_USER_NAME} ${CUSTOM_USER_NAME}
RUN mkdir -p /home/${CUSTOM_USER_NAME}/.composer && \
    chown -R ${CUSTOM_USER_NAME}:${CUSTOM_USER_NAME} /home/${CUSTOM_USER_NAME}

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

CMD composer i -o ; wait-for-it service-mariadb:3306 -- bin/console doctrine:migrations:migrate ;  php-fpm

EXPOSE 9000

# Change to the new user
USER ${CUSTOM_USER_NAME}
