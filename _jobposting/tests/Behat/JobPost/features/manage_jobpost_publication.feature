# language: it
Funzionalità: Gestione del periodo di pubblicazione
  delle offerte di lavoro nell'area di amministrazione.

  Per poter gestire la pubblicazione delle offerte di lavoro visibili
  nell'area pubblica del sito
  Come utente amministratore
  voglio poter configurare e modificare la data di pubblicazione e/o la data di scadenza
  delle offerte di lavoro.


  Contesto:
    Dato sono autenticato con privilegi di amministratore


  Scenario: Aggiunta di una nuova offerte di lavoro con data di pubblicazione
      ma senza la data di scadenza.
    E sono sulla pagina di creazione offerta di lavoro
    Quando compilo il campo "Titolo" con "Sistemista a milano"
    E compilo il campo "Descrizione" con "Cercasi urgentemente sistemista..."
    E compilo il campo "Inizio pubblicazione" con "2222-01-01"
    E premo "Salva"
    Allora dovrei essere sulla pagina di gestione offerte di lavoro
    E dovrei vedere "Nuova offerta di lavoro creata"
    Quando clicco "Sistemista a milano" nella riga "Sistemista a milano"
    Allora dovrei vedere "Dettaglio offerta di lavoro"
    E dovrei vedere "PUBBLICATO: 2222-01-01"


  Scenario: Aggiunta di una nuova offerte di lavoro con data di pubblicazione e
      data di scadenza.
    E sono sulla pagina di creazione offerta di lavoro
    Quando compilo il campo "Titolo" con "Sistemista a milano"
    E compilo il campo "Descrizione" con "Cercasi urgentemente sistemista..."
    E compilo il campo "Inizio pubblicazione" con "2222-01-01"
    E compilo il campo "Fine pubblicazione" con "2222-02-02"
    E premo "Salva"
    Allora dovrei essere sulla pagina di gestione offerte di lavoro
    E dovrei vedere "Nuova offerta di lavoro creata"
    Quando clicco "Sistemista a milano" nella riga "Sistemista a milano"
    Allora dovrei vedere "Dettaglio offerta di lavoro"
    E dovrei vedere "PUBBLICATO: 2222-01-01"
    E dovrei vedere "SCADE: 2222-02-02"
