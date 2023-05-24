# language: it
Funzionalità: Visualizzazione delle offerte di lavoro nell'area pubblica del sito.

  Come visitatore nell'area pubblica del sito
  devo poter visualizzare le offerte di lavoro pubblicate.


  Scenario: Visualizzazione delle offerte di lavoro pubblicate
    Dato il sistema è correttamente inizializzato con almeno un amministratore
    Dato sono presenti le seguenti offerte di lavoro
      | titolo     | pubblicato |
      | annuncio 1 | si         |
      | annuncio 2 | no         |
      | annuncio 3 | si         |
    E vado sulla pagina di visualizzazione offerte di lavoro
    Allora dovrei vedere "annuncio 1"
    E non dovrei vedere "annuncio 2"
    E dovrei vedere "annuncio 3"
