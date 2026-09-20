FROM "php:8.3.0-fpm"
 
# Arguments defined in docker-compose.yml
ARG user=admin
ARG uid=1000
 
# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip
 
# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
 
# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
 
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
 
# Create system user to run Composer and Artisan Commands
RUN id -u $user >/dev/null 2>&1 || useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user
 
# Set working directory
WORKDIR /var/www

# php-fpm workers default to www-data, which cannot write to the bind-mounted
# ./storage and ./bootstrap/cache (owned by whoever cloned the repo). The lab
# intentionally runs as root (spec: "RCE = full container control"), so run the
# FPM pool as root too, this also makes a fresh clone "just work" with no
# entrypoint and no manual chown.
RUN sed -i \
    -e 's/^user = www-data/user = root/' \
    -e 's/^group = www-data/group = root/' \
    /usr/local/etc/php-fpm.d/www.conf

USER $user

# --allow-to-run-as-root is required because the pool above now runs as root
CMD ["php-fpm", "-R"]