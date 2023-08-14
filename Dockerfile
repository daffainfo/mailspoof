FROM php:8.0-cli

WORKDIR /app

COPY main.php .

RUN apt-get update && apt-get install -y dnsutils

CMD ["php", "main.php"]