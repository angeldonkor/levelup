# LevelUp – Fitness Challenge Platform

LevelUp is een webapplicatie voor Momentum Lab waarmee sportleden kunnen deelnemen aan fitnesschallenges en hun resultaten kunnen bijhouden. Coaches kunnen challenges beheren, resultaten beoordelen en leaderboards publiceren.

## Functionaliteiten

### Sportlid

Een sportlid kan:

- inloggen;
- actieve challenges bekijken;
- deelnemen aan een challenge;
- een resultaat invoeren;
- een datum, waarde en bewijslink toevoegen aan een resultaat;
- eigen voortgang bekijken;
- de status van ingediende resultaten bekijken;
- gepubliceerde leaderboards bekijken.

### Coach

Een coach kan:

- inloggen;
- challenges aanmaken;
- challenges wijzigen;
- challenges verwijderen;
- ingestuurde resultaten bekijken;
- resultaten goedkeuren;
- resultaten afkeuren;
- resultaten markeren voor controle;
- leaderboards bekijken;
- leaderboards publiceren en intrekken.

Alleen goedgekeurde resultaten worden opgenomen in een leaderboard.

## Technieken

Het project is gebouwd met:

- PHP 8.2+
- Laravel 12
- MySQL
- Blade
- HTML
- CSS
- Git en GitHub

## Installatie

### 1. Repository clonen

```bash
git clone https://github.com/angeldonkor/levelup.git
cd levelup
```

### 2. PHP-packages installeren

```bash
composer install
```

### 3. Environment-bestand aanmaken

Maak een `.env`-bestand op basis van `.env.example`:

```bash
cp .env.example .env
```

### 4. Application key genereren

```bash
php artisan key:generate
```

### 5. Database aanmaken

Maak in MySQL of phpMyAdmin een database aan met de naam:

```text
levelup
```

Pas daarna in `.env` de database-instellingen aan:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=levelup
DB_USERNAME=root
DB_PASSWORD=
```

Pas `DB_USERNAME` en `DB_PASSWORD` aan wanneer jouw MySQL-installatie andere gegevens gebruikt.

### 6. Database opbouwen en testgegevens toevoegen

```bash
php artisan migrate --seed
```

### 7. Applicatie starten

```bash
php artisan serve
```

Open daarna:

```text
http://127.0.0.1:8000
```

## Testaccounts

Na het uitvoeren van de seeders zijn de volgende accounts beschikbaar.

### Sportlid

E-mail:

```text
member@levelup.test
```

Wachtwoord:

```text
LevelUp123!
```

### Coach

E-mail:

```text
coach@levelup.test
```

Wachtwoord:

```text
LevelUp123!
```

## Rollen en beveiliging

LevelUp gebruikt twee rollen:

- `member`
- `coach`

Een sportlid heeft geen toegang tot coachpagina's. Een coach heeft geen toegang tot pagina's die alleen voor sportleden bedoeld zijn.

Wachtwoorden worden gehasht opgeslagen. Formulieren maken gebruik van server-side validatie en CSRF-bescherming.

## Resultaten

Wanneer een sportlid een resultaat invoert, krijgt dit standaard de status `pending`.

Een coach kan het resultaat daarna wijzigen naar:

- `approved`
- `rejected`
- `review`

Alleen resultaten met de status `approved` worden gebruikt voor het leaderboard.

De ingevoerde waarde moet binnen de minimale en maximale waarde van de challenge vallen.

## Tests

De geautomatiseerde tests kunnen worden uitgevoerd met:

```bash
php artisan test
```

De tests controleren onder andere:

- toegang tot de loginpagina;
- doorsturen vanaf de homepage;
- rolgebaseerde toegang;
- deelnemen aan een challenge;
- validatie van resultaten;
- opslaan van geldige resultaten;
- uitsluiten van niet-goedgekeurde resultaten uit het leaderboard.

## Projectstructuur

Belangrijke onderdelen van het project:

```text
app/Http/Controllers
app/Http/Middleware
app/Models
database/migrations
database/seeders
resources/views
routes/web.php
tests/Feature
```

## GitHub

Repository:

https://github.com/angeldonkor/levelup