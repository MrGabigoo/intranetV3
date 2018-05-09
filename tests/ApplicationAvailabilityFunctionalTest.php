<?php
// tests/ApplicationAvailabilityFunctionalTest.php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class ApplicationAvailabilityFunctionalTest extends WebTestCase
{

    private $client = null;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url)
    {
        $this->logIn();

        $crawler = $this->client->request('GET', $url);
        $this->assertSame(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }

    public function urlProvider()
    {
        yield['/fr/administration/'];
        yield['/fr/agenda/'];
        yield['/fr/application/'];
        yield['/fr/'];
        yield['/fr/document/'];
        yield['/fr/document/ajax/typedocument'];
        yield['/fr/document/ajax/document/{typedocument}'];
        yield['/404'];
        yield['/fr/faq/'];
        yield['/fr/aide/'];
        //yield['/fr/aide/article/{sujet}'];
        //yield['/fr/aide/imprimer/{sujet}'];
        yield['/fr/informations/'];
        yield['/fr/internationale/'];
        yield['/fr/mentions-legales/'];
        yield['/fr/messagerie/'];
        //yield['/fr/messagerie/{message}'];
        yield['/fr/previsionnel/'];
        yield['/fr/previsionnel/chronologique'];
        yield['/fr/login'];

        yield['/fr/trombinoscope/'];
        yield['/fr/user/mon-profil'];
        //yield['/fr/user/{type}/{slug}'];
        yield['/fr/user/settings'];
        //yield['/fr/administration/absence/semestre/{semestre}/liste'];
        //yield['/fr/administration/absence/semestre/{semestre}/justifier'];
        //yield['/fr/administration/absence/semestre/{semestre}/saisie'];
        yield['/fr/administration/article/'];
        yield['/fr/administration/article/help'];
        yield['/fr/administration/article/save'];
        yield['/fr/administration/article/imprimer'];
        yield['/fr/administration/article/new'];
        //yield['/fr/administration/article/{id}'];
        //yield['/fr/administration/article/{id}/edit'];
        yield['/fr/cohorte/'];
        //yield['/fr/administration/commission-absence/semestre/{semestre}'];
        yield['/fr/administration/configuration/configuration'];
        yield['/fr/administration/date/'];
        yield['/fr/administration/date/help'];
        yield['/fr/administration/date/save'];
        yield['/fr/administration/date/imprimer'];
        yield['/fr/administration/date/new'];
        yield['/fr/administration/date/{id}'];
        //yield['/fr/administration/date/{id}/edit'];
        yield['/fr/administration/document/'];
        yield['/fr/administration/document/save'];
        yield['/fr/administration/document/imprimer'];
        yield['/fr/administration/document/new'];
        //yield['/fr/administration/document/{id}'];
        //yield['/fr/administration/document/{id}/edit'];
        yield['/fr/administration/emploi-du-temps/'];
        yield['/fr/administration/etudiant/'];
        //yield['/fr/administration/etudiant/semestre/{semestre}'];
        //yield['/fr/administration/etudiant/groupe/semestre/{semestre}'];
        //yield['/fr/administration/etudiant/fin-semestre/{semestre}'];
        yield['/fr/administration/groupe/'];
        yield['/fr/administration/matiere/'];
        yield['/fr/administration/matiere/help'];
        yield['/fr/administration/matiere/save'];
        yield['/fr/administration/matiere/imprimer'];
        yield['/fr/administration/matiere/new'];
        //yield['/fr/administration/matiere/{id}'];
        //yield['/fr/administration/matiere/{id}/edit'];
        //yield['/fr/administration/note/semestre/{semestre}'];
        yield['/fr/administration/personnel/'];
        yield['/fr/administration/personnel/help'];
        yield['/fr/administration/personnel/save'];
        yield['/fr/administration/personnel/imprimer'];
        yield['/fr/administration/personnel/add'];
        yield['/fr/administration/personnel/create'];
        //yield['/fr/administration/personnel/{id}'];
        //yield['/fr/administration/personnel/{id}/edit'];
        yield['/fr/administration/ppn/'];
        yield['/fr/administration/ppn/help'];
        yield['/fr/administration/ppn/save'];
        yield['/fr/administration/ppn/imprimer'];
        yield['/fr/administration/ppn/new'];
        //yield['/fr/administration/ppn/{id}'];
        //yield['/fr/administration/ppn/{id}/edit'];
        yield['/fr/administration/previsionnel/'];
        yield['/fr/administration/previsionnel/new'];
        yield['/fr/administration/previsionnel/imprimer'];
        yield['/fr/administration/previsionnel/save'];
        //yield['/fr/administration/rattrapge/semestre/{semestre}'];
        //yield['/fr/administration/semestre/{semestre}'];
        //yield['/fr/administration/etudiant/sous-comission/{semestre}'];
        yield['/fr/administration/stage/'];
        yield['/fr/administration/stage/gestion/'];
        yield['/fr/administration/statistique/'];
        yield['/fr/administration/structure/'];
        yield['/fr/administration/type-document/'];
        yield['/fr/administration/type-document/help'];
        yield['/fr/administration/type-document/save'];
        yield['/fr/administration/type-document/imprimer'];
        yield['/fr/administration/type-document/new'];
        //yield['/fr/administration/type-document/{id}'];
        //yield['/fr/administration/type-document/{id}/edit'];
        yield['/fr/administration/structure/annee/'];
        yield['/fr/administration/structure/annee/help'];
        yield['/fr/administration/structure/annee/save'];
        yield['/fr/administration/structure/annee/imprimer'];
        //yield['/fr/administration/structure/annee/new/{diplome}'];
        //yield['/fr/administration/structure/annee/{id}'];
        //yield['/fr/administration/structure/annee/{id}/edit'];
        yield['/fr/administration/structure/diplome/'];
        yield['/fr/administration/structure/diplome/help'];
        yield['/fr/administration/structure/diplome/save'];
        yield['/fr/administration/structure/diplome/imprimer'];
        //yield['/fr/administration/structure/diplome/new/{formation}'];
        //yield['/fr/administration/structure/diplome/{id}'];
        //yield['/fr/administration/structure/diplome/{id}/edit'];
        yield['/fr/administration/structure/formation/'];
        yield['/fr/administration/structure/formation/help'];
        yield['/fr/administration/structure/formation/save'];
        yield['/fr/administration/structure/formation/imprimer'];
        yield['/fr/administration/structure/formation/new'];
        //yield['/fr/administration/structure/formation/{id}'];
        //yield['/fr/administration/structure/formation/{id}/edit'];
        yield['/fr/administration/structure/semestre/'];
        yield['/fr/administration/structure/semestre/help'];
        yield['/fr/administration/structure/semestre/save'];
        yield['/fr/administration/structure/semestre/imprimer'];
        //yield['/fr/administration/structure/semestre/new/{annee}'];
        //yield['/fr/administration/structure/semestre/{id}'];
        //yield['/fr/administration/structure/semestre/{id}/edit'];
        yield['/fr/administration/structure/ue/'];
        yield['/fr/administration/structure/ue/help'];
        yield['/fr/administration/structure/ue/save'];
        yield['/fr/administration/structure/ue/imprimer'];
        //yield['/fr/administration/structure/ue/new/{semestre}'];
        //yield['/fr/administration/structure/ue/{id}'];
        //yield['/fr/administration/structure/ue/{id}/edit'];
        /*yield['/api/etudiant/semestre/{semestre}'];
        yield['/api/etudiant/formation'];
        yield['/api/personnel/enseignants/{type}'];
        yield['/api/personnel/personnel/recherche/{needle}'];
        yield['/api/personnel/personnel/formation/add/{slug}'];*/
        yield['/fr/application/etudiant/absence/absence'];
        //yield['/fr/application/personnel/absence/{matiere}'];
        //yield['/fr/application/personnel/absence/saisie/{matiere}'];
        yield['/fr/application/personnel/absence/aide'];
        //yield['/fr/application/personnel/absence/save/{matiere}'];
        //yield['/fr/application/personnel/absence/imprimer/{matiere}'];
       // yield['/fr/application/personnel/absence/{id}'];
       // yield['/fr/application/personnel/note/{matiere}'];
       // yield['/fr/application/personnel/note/saisie/{matiere}'];
        yield['/fr/application/personnel/note/aide'];
        //yield['/fr/application/personnel/note/save/{evaluation}'];
        //yield['/fr/application/personnel/note/imprimer/{evaluation}'];
        //yield['/fr/application/personnel/note/{id}'];
        yield['/fr/social/'];
        yield['/fr/super-administration/'];
        yield['/fr/super-administration/site/'];
        yield['/fr/super-administration/site/help'];
        yield['/fr/super-administration/site/save'];
        yield['/fr/super-administration/site/imprimer'];
        yield['/fr/super-administration/site/new'];
        //yield['/fr/super-administration/site/{id}'];
        //yield['/fr/super-administration/site/{id}/edit'];
        yield['/fr/super-administration/type-diplome/'];
        yield['/fr/super-administration/type-diplome/save'];
        yield['/fr/super-administration/type-diplome/imprimer'];
        yield['/fr/super-administration/type-diplome/new'];
        //yield['/fr/super-administration/type-diplome/{id}'];
        //yield['/fr/super-administration/type-diplome/{id}/edit'];
        yield['/fr/super-administration/type-hrs/'];
        yield['/fr/super-administration/type-hrs/help'];
        yield['/fr/super-administration/type-hrs/save'];
        yield['/fr/super-administration/type-hrs/imprimer'];
        yield['/fr/super-administration/type-hrs/new'];
       // yield['/fr/super-administration/type-hrs/{id}'];
        //yield['/fr/super-administration/type-hrs/{id}/edit'];
        yield['/fr/super-administration/ufr/'];
        yield['/fr/super-administration/ufr/help'];
        yield['/fr/super-administration/ufr/save'];
        yield['/fr/super-administration/ufr/imprimer'];
        yield['/fr/super-administration/ufr/new'];
        //yield['/fr/super-administration/ufr/{id}'];
       // yield['/fr/super-administration/ufr/{id}/edit'];
        yield['/fr/logout'];

    }

    private function logIn()
    {
        $session = $this->client->getContainer()->get('session');

        // the firewall context defaults to the firewall name
        $firewallContext = 'main';

        $token = new UsernamePasswordToken('annebi01', 'test', $firewallContext, array('ROLE_PERMANENT'));
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}