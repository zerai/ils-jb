# language: it

Funzionalità: Gestione offerte di lavoro nell'area di amministrazione
  Per poter gestire le offerte di lavoro visibili
  nell'area pubblica del sito
  Come utente amministratore
  voglio poter aggiungere/modificare/eliminare le offerte.


  Contesto:
    Dato sono autenticato con privilegi di amministratore

  Scenario: Lista di offerte di lavoro
    Dato ci sono 8 offerte di lavoro
    E io sono sulla pagina "/admin/jobpost"
    Allora dovrei vedere 8 offerte di lavoro

  Scenario: Aggiunta di una nuova offerte di lavoro
    E io sono sulla pagina "/admin/jobpost/new"
    Quando compilo il campo "Titolo" con "Sistemista a milano"
    E compilo il campo "Descrizione" con "Cercasi urgentemente sistemista..."
    E premo "Salva"
    Allora dovrei vedere "Nuova offerta di lavoro creata"
    E dovrei vedere "Sistemista a milano"

  Scenario: Cancellazione di un'offerta di lavoro

    Elimino una specifica offerta di lavoro
    da una lista di offerte
    presenti nel sistema.

    Dato sono presenti le seguenti offerte di lavoro
      | titolo              |
      | Grafico a Roma      |
      | Sistemista a Milano |
    E sono sulla pagina "/admin/jobpost"
    Quando clicco "Elimina" nella riga "Sistemista a Milano"
    Allora dovrei vedere "Offerta di lavoro eliminata"
    E non dovrei vedere "Sistemista a Milano"
    Ma dovrei vedere "Grafico a Roma"