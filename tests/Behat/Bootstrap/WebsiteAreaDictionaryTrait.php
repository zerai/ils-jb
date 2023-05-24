<?php declare(strict_types=1);

namespace App\Tests\Behat\Bootstrap;

trait WebsiteAreaDictionaryTrait
{
    /**
     * Apre l'homepage del sito
     *
     * Esempio: Dato sono sulla homepage
     * Esempio: E sono sulla homepage
     * Esempio: Quando vado sulla homepage
     * Esempio: E vado sulla homepage
     *
     * @Given /^sono sulla homepage del sito$/
     * @When /^vado sulla homepage del sito$/
     */
    public function sonoSullaHomepage(): void
    {
        $this->visitPath('/');
    }

    /**
     * Apre la pagina di visualizazione delle offerte di lavoro
     *
     * Esempio: Dato sono sulla pagina di visualizazione offerte di lavoro
     * Esempio: E sono sulla pagina di visualizazione offerte di lavoro
     * Esempio: Quando vado sulla pagina di visualizazione offerte di lavoro
     * Esempio: E vado sulla pagina di visualizazione offerte di lavoro
     *
     * @Given /^sono sulla pagina di visualizzazione offerte di lavoro$/
     * @When  /^vado sulla pagina di visualizzazione offerte di lavoro$/
     * * /^sono sulla pagina di visualizzazione offerte di lavoro$/
     */
    public function sonoSullaPaginaDiVisualizzazioneOfferteDiLavoro(): void
    {
        $this->visitPath('/lavoro');
    }
}
