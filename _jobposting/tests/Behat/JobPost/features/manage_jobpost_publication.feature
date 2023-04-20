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
    E compilo il campo "Inizio pubblicazione" con "2050-01-01"
    E premo "Salva"
    Allora dovrei essere sulla pagina di gestione offerte di lavoro
    E dovrei vedere "Nuova offerta di lavoro creata"
    Quando clicco "Sistemista a milano" nella riga "Sistemista a milano"
    Allora dovrei vedere "Dettaglio offerta di lavoro"
    E dovrei vedere "PUBBLICATO: 2050-01-01"


  Scenario: Aggiunta di una nuova offerte di lavoro con data di pubblicazione e
      data di scadenza.
    E sono sulla pagina di creazione offerta di lavoro
    Quando compilo il campo "Titolo" con "Sistemista a milano"
    E compilo il campo "Descrizione" con "Cercasi urgentemente sistemista..."
    E compilo il campo "Inizio pubblicazione" con "2050-01-01"
    E compilo il campo "Fine pubblicazione" con "2050-02-02"
    E premo "Salva"
    Allora dovrei essere sulla pagina di gestione offerte di lavoro
    E dovrei vedere "Nuova offerta di lavoro creata"
    Quando clicco "Sistemista a milano" nella riga "Sistemista a milano"
    Allora dovrei vedere "Dettaglio offerta di lavoro"
    E dovrei vedere "PUBBLICATO: 2050-01-01"
    E dovrei vedere "SCADE: 2050-02-02"


  Scenario: Modifica il periodo di pubblicazione in una offerte di lavoro esistente
    E sono presenti le seguenti offerte di lavoro
      | titolo     | inizio pubblicazione | fine pubblicazione |
      | annuncio 1 | 2050-06-01           | 2050-07-01         |
      | annuncio 2 |                      |                    |
    E vado sulla pagina di gestione offerte di lavoro
    E clicco "Modifica" nella riga "annuncio 1"
    Quando compilo il campo "Inizio pubblicazione" con "2050-06-10"
    E compilo il campo "Fine pubblicazione" con "2050-07-10"
    E premo "Salva"
    Allora dovrei vedere "Dettaglio offerta di lavoro"
    E dovrei vedere "PUBBLICATO: 2050-06-10"
    E dovrei vedere "SCADE: 2050-07-10"
