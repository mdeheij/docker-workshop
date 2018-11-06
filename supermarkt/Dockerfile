FROM php:7-alpine

WORKDIR /app
COPY index.php /app/index.php

RUN docker-php-ext-install mysqli

CMD ["php", "-S", "0.0.0.0:80"]