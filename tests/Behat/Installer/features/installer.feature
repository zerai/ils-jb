#language: it
Funzionalità: Processo di installazione
    Nella circostanza di 'primo utilizzo' dell'applicativo,
    il sistema dovrebbe avviare automaticamente la procedura
    di installazione, e negare l'accesso a tutte le altre aree
    dell'applicativo.

    Viene considerata circostanza di 'primo utilizzo' ogni qualvolta
    nel sistema non sia correttamente registrato/abilitato
    almeno 1 account con privilegi amministrativi.

    La procedura di installazione è composta dai seguenti step

    - verifica delle librerie/estensioni nel sistema
    - creazione del primo account di amministrazione
    - TODO - ?(prob. non necessario) configurazione dei parametri per il corretto funzionamento
        - TODO ? - configurazione database
        - TODO ? - configurazione email account


    Scenario: Il processo di installazione si avvia automaticamente
        Oltre all'avvio dell'installer
        verifico che l'homepage non sia accessibile

        Dato il sistema non è inizializzato correttamente
        E vado sulla homepage del sito
        Allora dovrei vedere "Procedura di installazione avviata"
        E dovrei essere sulla pagina di installazione

