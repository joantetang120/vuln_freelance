FROM php:8.2-apache

# 1️⃣ Install required tools
RUN apt-get update && \
    apt-get install -y netcat-traditional && \
    rm -rf /var/lib/apt/lists/*

# 2️⃣ Enable PostgreSQL extension
RUN apt-get update && apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql && \
    rm -rf /var/lib/apt/lists/*

# 3️⃣ Enable Apache modules
RUN a2enmod rewrite

# 4️⃣ Set Apache DocumentRoot to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# 5️⃣ Copy app files
COPY public/ /var/www/html/public/
COPY src/ /var/www/html/src/
COPY templates/ /var/www/html/templates/
COPY config/ /var/www/html/config/

# 6️⃣ Make app code read-only
RUN chown -R root:root /var/www/html && \
    chmod -R 755 /var/www/html  

# 7️⃣ Ensure uploads dir exists and writable for Apache
RUN mkdir -p /var/www/html/public/uploads && \
    chown -R www-data:www-data /var/www/html/public/uploads && \
    chmod 733 /var/www/html/public/uploads

# 8️⃣ Allow PHP execution in uploads, no open_basedir restriction
# 🔹 This allows shells to read /home, /etc/passwd, etc.
RUN echo "<Directory /var/www/html/public/uploads>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride None\n\
    Require all granted\n\
</Directory>\n" > /etc/apache2/conf-enabled/uploads.conf

# 🔟 Add wait-for-db script
COPY wait-for-db.sh /usr/local/bin/wait-for-db.sh
RUN chmod +x /usr/local/bin/wait-for-db.sh

# 🔟 Create flag file in home directory
RUN echo "spider{Hel10__5yst3m_Flag_1001}" > /home/flag.txt && \
    chmod 644 /home/flag.txt

EXPOSE 80
CMD ["apache2-foreground"]
