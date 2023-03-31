# language: it
Funzionalità: Gestione amministratori nell'area di amministrazione
    Per poter gestire gli account amministratore
    Come utente amministratore
    voglio poter aggiungere/visualizzare/modificare/eliminare gli account.


    Scenario: Visualizzazione dettagliata di un'account amministratore
        Dato sono autenticato con privilegi di amministratore
        E sono presenti i seguenti account con ruolo di amministratore
            | email                |
            | admin001@example.com |
        Quando vado sulla pagina di gestione amministratori
        E clicco "admin001@example.com" nella riga "admin001@example.com"
        Allora dovrei vedere "Dettaglio account"
        E dovrei vedere "admin001@example.com"
        E dovrei vedere "ROLE_ADMIN"


    Scenario: Cancellazione di un'account di amministrazione

        Elimino una specifico account
        da una lista di account
        presenti nel sistema.

        Dato sono autenticato con privilegi di amministratore
        E sono presenti i seguenti account con ruolo di amministratore
            | email              |
            | admin-1@email.com |
            | admin-2@email.com |
        Quando vado sulla pagina di gestione amministratori
        E premo "Elimina" nella riga "admin-2@email.com"
        Allora dovrei vedere "Account eliminato"
        E non dovrei vedere "admin-2@email.com"
        Ma dovrei vedere "admin-1@email.com"


    Scenario: Non visualizza pulsante elimina nella gestione amministratori

        Nel caso nel sistema sia presente un solo
        account di amministrazione
        nella visualizzazione lista il pulsante
        Elimina non viene mostrato

        Dato sono autenticato con privilegi di amministratore
        E sono sulla pagina di gestione amministratori
        E non dovrei vedere "Elimina"
