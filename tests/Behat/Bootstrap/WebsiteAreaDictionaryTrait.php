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
}
