# language: it

Funzionalità: Autenticazione al sistema via web ui.

  Come utente amministratore
  voglio poter eseguire le procedure di login
  voglio poter accedere all' area protetta del sistema
  voglio poter eseguire la procedura di logout.

  Contesto:
    Data il sistema è correttamente inizializzato con almeno un amministratore
    Data io sono sulla pagina "/login"


  Scenario: Eseguo la procedura di login come amministratore

    Dato un account amministratore con email "administrator.test@example.com" e password "my-password"
    Quando compilo il campo "username" con "administrator.test@example.com"
    E compilo il campo "password" con "my-password"
    E premo "login"
    Allora dovrei essere sulla pagina "/"


  Scenario: Eseguo la procedura di logout come amministratore

    Dato un account amministratore con email "administrator.test@example.com" e password "my-password"
    Quando compilo il campo "username" con "administrator.test@example.com"
    E compilo il campo "password" con "my-password"
    E premo "login"
    Allora dovrei essere sulla pagina "/"
    E clicco sul link "Logout"
    Allora non dovrei vedere l'elemento "Logout"


  Scenario: Sono abilitato all'accesso nell'area amministrativa
    Dato sono autenticato con privilegi di amministratore
    Quando vado alla pagina "/admin/administrator"
    Allora dovrei vedere "Amministratori"
