---
currentMenu: setup
---

# Setup e Sviluppo (LINUX)

Assicurati di avere i seguenti tools installati nella tua macchina di sviluppo:
- php
- git
- composer

## Download del codice sorgente
```
git clone https://github.com/zerai/ils-jb.git
chmod -R 775 ils-jb/
cd ils-jb
composer install
```

## Download tools di sviluppo

Il repository è provvisto di tools 'secondari' per la gestione 
di test, qualità e metriche del codice, documentazione.

E' possibile e consigliata, un' installazione veloce tramite un unico
comando.

```
composer bin all install
```

## Sviluppo e uso dell'applicazione

Una volta clonato il repository, e dopo aver installato tutti i tools necessari,
modificare il file .env inserendo i parametri di configurazione del proprio database
locale.

Con il database correttamente configurato, è necassario eseguire i seguenti comandi per 
creare lo schema del database e caricare le fixture minime di sviluppo che contengono
i dati di login.


```
# crea il database 
./bin/console doctrine:database:create

# aggiorna lo schema del database
./bin/console doctrine:schema:update --force

# carica le fixtures di sviluppo
./bin/console doctrine:fixtures:load --group dev

```

Apri il browser all'indirizzo 'http://127.0.0.1' per visualizzare l'area pubblica dell'applicazione

(l'url dipende dalla propria configurazione LAMP)

Oppure vai all'indirizzo 'http://127.0.0.1/login' per accedere all'area amministrativa.

DATI DI LOGIN

email: admin@example.com

password: admin


## Run dei test, altri tools e CD/CI

Il codice del repository viene fornito con una [pipeline](https://github.com/zerai/ils-jb/actions) di test eseguiti ad ogni push/pull
tramite le GITHUB ACTIONS.

Oltre ai vari tests (phpunit/behat), viene eseguito un check dei coding standard ed un'analisi statica del codice.
Si consiglia di eseguire manualmente in locale gli stessi controlli prima di ogni commit, a tal proposito
vengono forniti degli shortcut configurati nel file composer.json.
```json lines
    "scripts-descriptions": {
        "cs": "Check php coding style",
        "cs:fix": "Fix php coding style",
        "rc": "Check rector roules",
        "rc:fix": "Fix rector issues",
        "sa": "Check static analysis (phpstan)",
        "tf": "Run functional testsuite",
        "ti": "Run integration testsuite",
        "tu": "Run unit testsuite"
    }
```
Esempi:
```shell
# esegue i test unitari tramite phpunit
composer tu

# esegue un controllo dei coding standard
composer cs

# fix dei file secondo i coding standard configurati
composer cs:fix
```





