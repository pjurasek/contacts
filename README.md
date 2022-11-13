# Contacts

This is a demo app for contacts.

### Using Docker

You need  [Docker](https://github.com/docker/docker) and  [docker-compose](https://github.com/docker/compose) and make.

### Installation

First, clone repository:

```bash
$ git clone https://github.com/pjurasek/contacts.git
```

Build Docker images:

```bash
$ make build
```

Run Docker containers:

```bash
$ make start
```

### How it works?

The `docker-compose` built images:
- `mariadb`: This is the Maria database container.
- `php-fpm`: This is the PHP FPM container including the application volume mounted on.
- `nginx`: This is the Nginx web server container in which php volume are mounted on.

The result is the following running containers:
```bash
$ cd docker && docker-compose ps
```

### Troubleshooting
Remove container
```bash
$ docker container rm -f <id-container>
```

### Contact form

Contact form is available on the URL

```
http://localhost
```

### Preview

<img src="https://raw.githubusercontent.com/pjurasek/contacts/master/symfony/docs/contacts-app.png" />
