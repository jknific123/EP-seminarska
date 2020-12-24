# EP-seminarska

Uporabniški računi in gesla:

admin: nikak@gmail.com, geslo12345
prodajalec: knifo@gmail.com, geslo12345
stranka: kirba@gmail.com, geslo12345

Za uprabo spletne trgovine je najprej treba naložiti bazo:

(mysql -u root -p < NetBeansProjects/Seminarska/EP-seminarska/conf/sql/toystoredbCreate.sql)

Nato naložimo še testne podatke z ukazom:

 (mysql -u root -p < NetBeansProjects/Seminarska/EP-seminarska/conf/sql/toystoredbResetData.sql)

Po tem je spletna trgovina pripravljena na uporabo.


Certifikati:
1. Skopiraj datoteke, ki so v apache2/ssl in apache2/sites-available v etc/apache2/ssl in etc/apache2/sites-available. Najbrz bos moral/a to naredit z terminalom in sudo cp.
1.1 sudo mkdir /etc/apache2/ssl
1.2 sudo cp #kaj kopiras* /etc/apache2/ssl
1.3 sudo a2enmod ssl
1.4 sudo a2ensite default-ssl.conf
1.5 sudo a2enmod rewrite

2. Pojdi v FireFox, pod preferences -> view certificates -> import in importaj Toystore_CA.pem datoteko kot certifikat. Mora biti pod tab Autorities.
2.1 importaj še uporabniške certifikate (datoteke .p12). Geslo je geslo12345. Pod tab uporabniški certifikati.
3. podji v terminal in vpisi: sudo service apache2 restart
4. Kot anonimni uporabnik boš preusmerjen/a na nezavarovani kanal. 

Nasa certifikatna agencija: Toystore CA, geslo za edit: geslo12345
