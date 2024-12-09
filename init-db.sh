#!/bin/bash
# MySQL başlatıldığında dump dosyasını yüklemek için bu script çalışacak

# Dump dosyasının yolu
DUMP_FILE="/var/www/html/db-exported/vesthub.sql"

# Eğer dump dosyası varsa, veritabanını yükle
if [ -f "$DUMP_FILE" ]; then
    echo "Dump dosyasi bulunuyor, veritabanini yüklüyoruz..."
    mysql -u root -prootpass $MYSQL_DATABASE < $DUMP_FILE
else
    echo "Dump dosyasi bulunamadi!"
fi