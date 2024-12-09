# PHP ve Apache tabanlı resmi imajı kullan
FROM php:8.2-apache

# Gerekli PHP uzantılarını kur
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite

# Apache konfigürasyonunu düzenle
RUN echo "<Directory /var/www/html>\n    Options +Indexes\n    AllowOverride All\n    Require all granted\n</Directory>" >> /etc/apache2/apache2.conf

# Apache modüllerini etkinleştir
RUN a2enmod rewrite

# Apache'yi yeniden başlat
CMD ["apache2-foreground"]

# Frontend klasörünü web kök dizinine kopyala
COPY ./ /var/www/html

# MySQL import işlemi için script ekliyoruz
COPY ./init-db.sh /docker-entrypoint-initdb.d/

# Çalıştırılabilir izin veriyoruz
RUN chmod +x /docker-entrypoint-initdb.d/init-db.sh

# Apache yapılandırması (opsiyonel, URL yönlendirme için)
WORKDIR /var/www/html