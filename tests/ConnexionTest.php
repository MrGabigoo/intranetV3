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
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ConnexionTest extends WebTestCase
{
    public function testConnexion()
    {
        $client = static::createClient(
            [
                'environment' => 'test',
                'debug'       => false
            ]);

        $client->request('GET', '/connexion');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testAide()
    {
        $client = static::createClient(
            [
                'environment' => 'test',
                'debug'       => false
            ]);


        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('annebi01', 'test', $firewallContext, array('ROLE_PERMANENT'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);


        $client->request('GET', '/aide/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testFaq()
    {
        $client = static::createClient(
            [
                'environment' => 'test',
                'debug'       => false
            ]);


        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('annebi01', 'test', $firewallContext, array('ROLE_PERMANENT'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);


        $client->request('GET', '/faq/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());


    }

    public function test404()
    {
        $client = static::createClient(
            [
                'environment' => 'test',
                'debug'       => false
            ]);


        $session = $client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('annebi01', 'test', $firewallContext, array('ROLE_PERMANENT'));
        $session->set('_security_' . $firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);




        $client->request('GET', '/404');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}