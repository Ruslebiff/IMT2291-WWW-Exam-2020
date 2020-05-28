# imt2291 eksamen v2019
* Lag en FORK av dette repositoriet og gi meg leserettigheter (aland.a.mendoza@ntnu.no). Det som er i repositoriet på slutten av eksamen teller som din besvarelse.
* Legg inn studentnummeret ditt øverst i readme.md fila.
* I oppgave 1-3 kan du bruke oppsettet i mappen oppgave1-3, eller du kan bruke standard PHP / MYSQL server (f.eks. XAMPP) og opprette database med oppgave1-3/dbInit/myDB.sql. Kjør composer install for å installere Twig.
* IKKE kjør "npm install" i www mappa i oppgave1-3, se siste kommentar i oppgave 3.

## Oppgave 1 (PHP)
*Merk: Bruk twig til å presentere data*

Lag en side som har et skjema for å lage en ny bruker. Brukerinfo vil være:
brukernavn (e-post adresse), passord, fornavn, etternavn.

Valider data både på client og server: gyldig e-post adresse, minimum passord lengde på 8 tegn, at fornavn og etternavn ikke er tomme.

Samme side (skript) som viser fram skjemaet skal også motta dataen. Lagre den nye brukeren i database, og gi fornuftige suksess/feil meldinger. Bruk twig til å presentere data.

## Oppgave 2 (JavaScript)
*Merk: det er ferdige PHP skript i oppgave1-3/www/api for å hente og oppdatere informasjon.*

Lag en side som lister ut alle brukere. Hent brukere fra api/fetchUsers.php med fetch i JavaScript. Vis lista med brukere på venstre side av skjermen. Når en bruker velges fra lista skal et skjema for å redigere brukerens info vises på høyre side av skjermen.

All informasjon om brukeren burde være mulig å redigere, bortsett fra autogenerert ID i databasen. Send brukernavn/fornavn/etternavn/passord til serveren når brukeren trykker på en knapp. Bruk her fetch med POST metoden, og send det til api/updateUser.php.

For å oppdatere fornavn/etternavn trenger du ikke oppgi det gamle passordet, men for å endre brukernavn og/eller passord må det gamle passordet oppgis. Se api/updateUser.php for detaljer.

## Oppgave 3 (Web komponenter)
I denne oppgaven skal du lage samme funksjonaliteten som i oppgave 2, bare med web komponenter. I filen oppgave3.html finner du startpunktet for denne oppgaven. Denne filen bruker users-list.js komponenten i js/components mappen til å lage en liste av alle brukere, funksjonaliteten i denne komponenten er ferdig laget. I render (på linje 56) brukes en edit-user.js komponent, denne komponenten får tilsendt den valgte brukeren. Det som mangler i edit-user.js er funksjonaliteten for å oppdatere en bruker.

Fullfør edit-user.js slik at den lar deg redigere en bruker på samme måte som i oppgave 2. Du vil trenge å vise et HTML-skjema, og en metode for å sende brukerdata til serveren.

NB, i oppgave1-3/www/node_modules ligger lit-element med de endringer som skal til for at det fungerer uten å bruke "polymer serve" (dvs, koden fungerer direkte i docker/XAMPP).
