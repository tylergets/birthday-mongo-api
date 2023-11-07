# Use the official PHP 8 image as base
FROM php:8-cli

# Install system dependencies for MongoDB extension
RUN apt-get update && apt-get install -y \
    libbson-1.0-0 \
    libmongoc-1.0-0 \
    libcurl4-openssl-dev \
    pkg-config  \
    libssl-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Clean up the apt cache to reduce the image size
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set the working directory in the container
WORKDIR /app

# Run the PHP CLI
CMD [ "php", "-a" ]
