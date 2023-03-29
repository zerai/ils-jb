# language: it
Funzionalità: Gestione offerte di lavoro nell'area di amministrazione
  Per poter gestire le offerte di lavoro visibili
  nell'area pubblica del sito
  Come utente amministratore
  voglio poter aggiungere/visualizzare/modificare/eliminare le offerte.


  Contesto:
    Dato sono autenticato con privilegi di amministratore


  Scenario: Aggiunta di una nuova offerte di lavoro
    E sono sulla pagina di creazione offerta di lavoro
    Quando compilo il campo "Titolo" con "Sistemista a milano"
    E compilo il campo "Descrizione" con "Cercasi urgentemente sistemista..."
    E premo "Salva"
    Allora dovrei essere sulla pagina di gestione offerte di lavoro
    E dovrei vedere "Nuova offerta di lavoro creata"
    E dovrei vedere "Sistemista a milano"


  Scenario: Visualizzazione dettagliata di un'offerte di lavoro
    Dato sono presenti le seguenti offerte di lavoro
      | titolo    | descrizione                                |
      | Webmaster | Cercasi webmaster, sede di lavoro Ravenna. |
    E sono sulla pagina di gestione offerte di lavoro
    Quando clicco "Cercasi webmaster, sede di lavoro Ravenna." nella riga "Cercasi webmaster, sede di lavoro Ravenna."
    Allora dovrei vedere "Dettaglio offerta di lavoro"
    Allora dovrei vedere "Cercasi webmaster, sede di lavoro Ravenna."


  Scenario: Visualizzazione di una lista di offerte di lavoro
    Dato ci sono 8 offerte di lavoro
    E sono sulla pagina di gestione offerte di lavoro
    Allora dovrei vedere 8 offerte di lavoro


  Scenario: Cancellazione di un'offerta di lavoro

    Elimino una specifica offerta di lavoro
    da una lista di offerte
    presenti nel sistema.

    Dato sono presenti le seguenti offerte di lavoro
      | titolo              |
      | Grafico a Roma      |
      | Sistemista a Milano |
    E sono sulla pagina di gestione offerte di lavoro
    Quando clicco "Elimina" nella riga "Sistemista a Milano"
    Allora dovrei vedere "Offerta di lavoro eliminata"
    E non dovrei vedere "Sistemista a Milano"
    Ma dovrei vedere "Grafico a Roma"


  Scenario: Modifica di un'offerta di lavoro
    Dato sono presenti le seguenti offerte di lavoro
      | titolo      | descrizione                                 |
      | Webdesigner | Cercasi webdesigner, sede di lavoro torino. |
    E sono sulla pagina di gestione offerte di lavoro
    Quando clicco "Modifica" nella riga "Cercasi webdesigner, sede di lavoro torino."
    Allora dovrei vedere "Modifica offerta di lavoro"
    Quando compilo il campo "Titolo" con "Webdesigner con esperienza"
    E compilo il campo "Descrizione" con "URGENTE: Cercasi webdesigner, sede di lavoro torino."
    E premo "Salva"
    Allora dovrei vedere "Offerta di lavoro modificata"
    E dovrei vedere "Webdesigner con esperienza"
    E dovrei vedere "URGENTE: Cercasi webdesigner, sede di lavoro torino."
