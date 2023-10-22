echo "Alte SQL Dateien (inkl gz) löschen"
rm -f /usr/local/bin/f1db.sql.gz
rm -f /usr/local/bin/f1db.sql

echo "Neue SQL Dateien herunterladen"
wget -O /usr/local/bin/f1db.sql.gz https://ergast.com/downloads/f1db.sql.gz
echo "SQL Datei entzippen"
gzip -d /usr/local/bin/f1db.sql.gz

echo "Alte Datenbank in eine sql Datei speichern"
mysqldump -u root f1db > old_f1db.sql

echo "Backup Datenbank erstellen"
mysql -u root -e "DROP DATABASE f1db_old;"
mysql -u root -e "CREATE DATABASE f1db_old;"

echo "Daten der alten Datenbank in die Backup Datenbank dumpen"
mysqldump -u root f1db | mysql -u root f1db_old

echo "Alte f1db Datenbank löschen"
mysql -u root -e "DROP DATABASE f1db;"

echo "Neue f1db Datenbank erstellen"
mysql -u root -e "CREATE DATABASE f1db;"

echo "Inhalt der neuen f1db.sql in die neue Datenbank schreiben"
mysql -u root f1db < /usr/local/bin/f1db.sql

echo "Eigene Views und Index Datei ausführen"
mysql -u root f1db < /usr/local/bin/master.sql