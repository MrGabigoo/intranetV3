<?php

namespace App\Controller;

use App\Entity\Favori;
use App\Repository\EtudiantRepository;
use App\Repository\FavoriRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UserController
 * @package App\Controller
 * @Route({"fr":"utilisateur/ajax",
 *         "en":"user/ajax"})
 */
class UserAjaxController extends BaseController
{
    /**
     * @param FavoriRepository   $favoriRepository
     * @param EtudiantRepository $etudiantRepository
     * @param Request            $request
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @Route("/add-favori", name="user_add_favori", options={"expose":true})
     */
    public function addFavori(
        FavoriRepository $favoriRepository,
        EtudiantRepository $etudiantRepository,
        Request $request
    ): Response {

        $action = $request->request->get('etat');
        $user = $etudiantRepository->findOneBySlug($request->request->get('user'));
        if ($user && $action === 'true') {
            $fav = new Favori($this->getUser(), $user);

            $this->entityManager->persist($fav);
            $this->entityManager->flush();

            return new Response('ok', Response::HTTP_OK);
        }

        if ($user && $action === 'false') {
            $fav = $favoriRepository->findBy(array(
                'etudiantDemandeur' => $this->getUser()->getId(),
                'etudiantDemande'   => $user->getId()
            ));
            foreach ($fav as $f) {
                $this->entityManager->remove($f);
            }
            $this->entityManager->flush();
            return new Response('ok', Response::HTTP_OK);
        }
        return new Response('nok', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
