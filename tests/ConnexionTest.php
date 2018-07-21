<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 21/07/2018
 * Time: 20:40
 */

// tests/Controller/PostControllerTest.php
namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConnexionTest extends WebTestCase
{
    public function testShowPost()
    {
        $client = static::createClient();

        $client->request('GET', '/connexion');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}