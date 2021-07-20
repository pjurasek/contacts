#!/usr/bin/env bash

# Updated command
#openssl req -x509 -newkey rsa:4096 -sha256 -days 3650 -nodes -keyout docker-symfony.key -out docker-symfony.crt -extensions san -config <(echo "[req]"; echo distinguished_name=req; echo "[san]"; echo subjectAltName=DNS:docker-symfony.com,DNS:docker-symfony.net,IP:10.0.0.1) -subj /CN=docker-symfony.com

# Shortened command
openssl req -x509 -newkey rsa:4096 -sha256 -days 3650 -nodes -keyout docker-symfony.key -out docker-symfony.crt -subj /CN=docker-symfony.test -addext subjectAltName=DNS:docker-symfony.test,DNS:docker-symfony.test,IP:10.0.0.1
