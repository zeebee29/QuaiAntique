<?php

namespace App\tests\WebTestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ReservationTest extends WebTestCase
{
    public function testValidReservation(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/reservation');

        $this->assertResponseIsSuccessful();
        
        $this->assertSelectorTextContains('h1', 'RESERVATION');

        //récupérer formulaire
        $submitBtn = $crawler->selectButton('Date >>');
        $form = $submitBtn->form();
        $form["reservation[nbConvive]"]=2;

        //Soumettre le formulaire
        $client->submit($form);

        //Vérifier statut HTTP
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
    }

    public function testInvalidReservation2(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/reservation2/20/1');
        //test redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        //force le suivi de la redirection
        $crawler = $client->followRedirect();

        $this->assertEquals(1, $crawler->filter('.message-box.alert.alert-warning:contains("Erreur sur le nombre de couverts.")')->count());


        $crawler = $client->request('GET', '/reservation2/-1/1');
        //test redirection
        $this->assertResponseStatusCodeSame(Response::HTTP_FOUND);
        //force le suivi de la redirection
        $crawler = $client->followRedirect();

        $this->assertEquals(1, $crawler->filter('.message-box.alert.alert-warning:contains("Erreur sur le nombre de couverts.")')->count());
    }    

    public function testValidReservation3(): void
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/reservation3/2/2023-10-24 20:00:00/2');

        $this->assertResponseIsSuccessful();
        
        $this->assertSelectorTextContains('h1', 'RESERVATION');

        $submitBtn = $crawler->selectButton('Confirmer');
        $form = $submitBtn->form();
        $form["reservation3[nbConvive]"]=2;
        $form["reservation3[dateReservation]"]="17/10/2023 - 20:00";
        $form["reservation3[telReserv]"]="0102030405";
        $form["reservation3[email]"]="test@test.tst";

        $client->submit($form);

        $this->assertTrue($client->getResponse()->isRedirect('/'));
        $this->assertSame(302, $client->getResponse()->getStatusCode());

        //$this->assertTrue($session->has('success'));
       // $crawler = $client->followRedirect();
        //$this->assertEquals(1, $crawler->filter('.message-box.alert.alert-success:contains("Votre réservation a été enregistrée. Confirmez-la grâce au lien envoyé dans votre boite mail.")')->count());

    }    

}
