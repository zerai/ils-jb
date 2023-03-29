<?php declare(strict_types=1);

namespace App\Tests\Behat\Bootstrap;

trait AdminDictionaryTrait
{
    /**
     * Apre la pagina di gestione delle offerte di lavoro
     *
     * Esempio: Dato sono sulla pagina di gestione offerte di lavoro
     * Esempio: E sono sulla pagina di gestione offerte di lavoro
     * Esempio: Quando vado sulla pagina di gestione offerte di lavoro
     * Esempio: E vado sulla pagina di gestione offerte di lavoro
     *
     * @Given /^sono sulla pagina di gestione offerte di lavoro$/
     * @When  /^vado sulla pagina di gestione offerte di lavoro$/
     * * /^sono sulla pagina di gestione offerte di lavoro$/
     */
    public function sonoSullaPaginaDiGestioneOfferteDiLavoro(): void
    {
        $this->visitPath('/admin/jobpost');
    }

    /**
     * Verifica che la pagina corrente sia quella
     * di gestione offerte di lavoro
     *
     * Example: Allora dovrei essere sulla pagina di gestione offerte di lavoro
     * Example: E dovrei essere sulla pagina di gestione offerte di lavoro
     *
     * @Then /^dovrei essere sulla pagina di gestione offerte di lavoro$/
     */
    public function assertPaginaDiGestioneOfferteDiLavoro(): void
    {
        $this->assertSession()->addressEquals($this->locatePath('/admin/jobpost'));
    }

    /**
     * Apre la pagina di creazione nuova offerta
     *
     * Esempio: Dato sono sulla pagina di creazione offerta di lavoro
     * Esempio: E sono sulla pagina di creazione offerta di lavoro
     * Esempio: Quando vado sulla pagina di creazione offerta di lavoro
     * Esempio: E vado sulla pagina di creazione offerta di lavoro
     *
     * @Given /^sono sulla pagina di creazione offerta di lavoro$/
     * @When /^vado sulla pagina di creazione offerta di lavoro$/
     */
    public function sonoSullaPaginaDiCreazioneOffertaDiLavoro(): void
    {
        $this->visitPath('/admin/jobpost/new');
    }
}
