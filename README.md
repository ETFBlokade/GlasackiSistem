# Glasački sistem za plenume
Jednostavan, open-source, besplatan sistem napravljen na ETFu. Svi studenti mogu da pristupe kodu. Dizajniran za korišćenje na svim fakultetima.

## Razlozi za korišćenje sistema
+ Anonimnost glasanja
+ Izbegavanje peer-pressure-a
+ Mogućnost više opcija za glasanje, umesto samo dve (jednostavno izvođenje anketa)
+ Brzo i precizno prebrojavanje glasova (može se koristiti za potrebe problema glasanja u Rektoratu)
+ Mogućnost simultanog glasanja na više fakulteta
+ Mogućnost tihog prekida diskusije, umesto čekanja 20 minuta da se diskusija završi
+ Druge potrebe koje možda trebaju drugim fakultetima sem ETF-a, sistem je u potpunosti dostupan njima

## Tehničko izvođenje
+ Jednostavno logovanje svih studenata (dovoljno je skenirati QR i glasati)
+ Mogućnost self-hostinga na Apache-u, pa otvaranja porta 80 ili tunellovanja (jednostavnije rešenje, i bezbedno je, opustite se)
+ Praćenje da svaki student može glasati samo jednanput
+ Zaštita adminskih stranica

## Izgled za glasače
Kada se skenira QR kod otvara se stranica, gde studenti mogu glasati za svoju opciju.

![image](https://github.com/user-attachments/assets/2eae81f2-989d-447b-86e6-6d6234766421)

## Izgled za administratore
Administratori imaju pristup dveju stranica, *admin.php* i *fetch_votes.php*

### Admin.php
Na ovoj stranici, mogu se podesiti opcije glasanja, kao i resetovati svi glasovi (što treba izbegavati dok je server publically accessible).

![image](https://github.com/user-attachments/assets/f8ec68fb-0570-4ea3-8f38-326376fa9105)

### Fetch_votes.php
Na ovoj stranici se mogu prikazati glasovi na projektoru. Stranica se ne refreshuje sama pa je potrebno refreshovati ručno.

![image](https://github.com/user-attachments/assets/4b937359-6db5-4412-9be2-0629fd2ebaad)

## Proces instalacije (jebiga iscimajte se 5min ima 5 koraka)
Pri izboru hostinga imate više opcija, da platite hosting, da se otvori port na ruteru, ili da se tunneluje preko nekog od online servisa. Ovde ćemo koristiti https://localhost.run/ , ali možete koristiti šta god hoćete.

1. Preuzeti i instalirati XAMPP (https://www.apachefriends.org/download.html)

![image](https://github.com/user-attachments/assets/8f1946e3-b1c0-4b8f-a039-00cbd70d7431)

2. Upakovati ovih 5 .php fajlova u folder gde je instaliran XAMPP (po defaultu C:\xampp\htdocs)

![image](https://github.com/user-attachments/assets/ae52a477-ac76-47c2-b5db-520179b1e104)

3. Upaliti Apache i MYSQL

![image](https://github.com/user-attachments/assets/fdcd3fb3-0ab6-4739-a51b-655d9ee77277)

4. Otvorite browser i ukucati URL localhost/phpmyadmin, u njemu ima tab SQL, otvoriti ga i paste-ovati kod iz SQLSetup.txt, zatim stisnuti GO u donjem delu ekrana

![image](https://github.com/user-attachments/assets/55a5e6ae-13e3-4a50-a2ab-268ad22f06bb)

5. Zatim treba napraviti da server bude javan. Otvoriti PowerShell, i ukucati komandu:

ssh -R 80:localhost:80 nokey@localhost.run

(Server se gasi sa ctrl+c)

TO JE TO

## Security
Promeniti username i password u fajlu admin.php

![image](https://github.com/user-attachments/assets/d2b319a6-dae7-4b05-ba05-7735f91a914b)

Promeni ime fajla phpmyadmina u bilo šta

![image](https://github.com/user-attachments/assets/e74357d4-add1-4aae-a926-4590356345fa)

## Problemi

+ Uložio sam 2h u ovo
+ Nije testirano robustno
+ Nije nenormalno bezbedno
+ Nije estetski lepo
+ NE ZNAM KOLIKO KONEKCIJA PODRZAVA LOCALHOST.RUN NAĆI DRUGI TUNNELING SERVIS MOŽDA

## Kontakt
etfblokada@proton.me
