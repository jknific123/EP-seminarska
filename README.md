# EP-seminarska
ooj

Certifikati:
1. Skopiraj datoteke, ki so v apache2/ssl in apache2/sites-available v etc/apache2/ssl in etc/apache2/sites-available. Najbrz bos moral/a to naredit z terminalom in sudo cp.
1.1 sudo mkdir /etc/apache2/ssl
1.2 sudo cp #kaj kopiras* /etc/apache2/ssl
1.3 sudo a2enmod ssl
1.4 sudo a2ensite default-ssl.conf

2. Pojdi v FireFox, pod preferences -> view certificates -> import in importaj Toystore_CA.pem datoteko kot certifikat.
3. podji v terminal in vpisi: sudo service apache2 restart
4. Povezi se z zavarovanim kanalom: https://localhost/netbeans/EP-seminarska/index.php/store

Nasa certifikatna agencija: Toystore CA, geslo za edit: geslo12345
