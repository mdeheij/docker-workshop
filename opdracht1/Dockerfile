# Use an official PHP (alpine) parent image from Docker hub
FROM php:7-alpine
WORKDIR /app

# Copy the current directory contents into the container at /app
COPY . /app

CMD ["php", "-S", "0.0.0.0:1337"]
