<?php

namespace App\Controller\appPersonnel;

use App\Controller\BaseController;
use App\Entity\CahierTexte;
use App\Events;
use App\Form\CahierTexteType;
use App\MesClasses\Csv\Csv;
use App\Repository\CahierTexteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CarnetController
 * @package App\Controller
 * @Route({"fr":"application/personnel/carnet",
 *         "en":"application/team/carnet"}
 *)
 * @IsGranted("ROLE_PERMANENT")
 */
class CarnetController extends BaseController
{
    /**
     * @Route("/", name="application_personnel_carnet_index", methods="GET")
     * @param CahierTexteRepository $cahierRepository
     *
     * @return Response
     */
    public function index(CahierTexteRepository $cahierRepository): Response
    {
        return $this->render(
            'appPersonnel/carnet/index.html.twig',
            ['cahierTextes' => $cahierRepository->findByPersonnel($this->getUser()->getId())]
        );
    }

    /**
     * @Route("/save", name="application_personnel_carnet_save", methods="GET")
     * @param Csv                   $csv
     * @param CahierTexteRepository $cahierRepository
     *
     * @return Response
     * @throws \Doctrine\Common\Annotations\AnnotationException
     */
    public function save(Csv $csv, CahierTexteRepository $cahierRepository): Response
    {
        $demandes = $cahierRepository->findByPersonnel($this->getUser()->getId());
        $csv->export('cahier-texte.csv', $demandes, array('application_carnet'));

        return $csv->response();
    }

    /**
     * @Route("/imprimer", name="application_personnel_carnet_print", methods="GET")
     */
    public function imprimer(): Response
    {
        //print (pdf)
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/new", name="application_personnel_carnet_new", methods="GET|POST")
     * @param Request                  $request
     * @param EventDispatcherInterface $eventDispatcher
     *
     * @return Response
     */
    public function create(
        Request $request,
        EventDispatcherInterface $eventDispatcher
    ): Response {
        $cahierTexte = new CahierTexte();
        $cahierTexte->setPersonnel($this->getUser());
        $form = $this->createForm(
            CahierTexteType::class,
            $cahierTexte,
            [
                'formation' => $this->dataUserSession->getFormation(),
                'attr'      => [
                    'data-provide' => 'validation'
                ]
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($cahierTexte);
            $this->entityManager->flush();

            //On déclenche l'event
            $event = new GenericEvent($cahierTexte);
            $eventDispatcher->dispatch(Events::CARNET_ADDED, $event);

            return $this->redirectToRoute('application_index', ['onglet' => 'carnet']);
        }

        return $this->render('appPersonnel/carnet/new.html.twig', [
            'cahierTexte' => $cahierTexte,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="application_personnel_carnet_show", methods="GET")
     * @param CahierTexte $cahierTexte
     *
     * @return Response
     */
    public function show(CahierTexte $cahierTexte): Response
    {
        return $this->render('appPersonnel/carnet/show.html.twig', ['cahierTexte' => $cahierTexte]);
    }

    /**
     * @Route("/{id}/edit", name="application_personnel_carnet_edit", methods="GET|POST")
     * @param Request                $request
     * @param CahierTexte            $cahierTexte
     *
     * @return Response
     */
    public function edit(Request $request, CahierTexte $cahierTexte): Response
    {
        $form = $this->createForm(
            CahierTexteType::class,
            $cahierTexte,
            [
                'formation' => $this->dataUserSession->getFormation(),
                'attr'      => [
                    'data-provide' => 'validation'
                ]
            ]
        );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('application_personnel_carnet_edit', ['id' => $cahierTexte->getId()]);
        }

        return $this->render('appPersonnel/carnet/edit.html.twig', [
            'cahierTexte' => $cahierTexte,
            'form'        => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="application_personnel_carnet_delete", methods="DELETE")
     * @param Request                $request
     * @param CahierTexte            $cahierTexte
     *
     * @return Response
     */
    public function delete(Request $request, CahierTexte $cahierTexte): Response
    {
        $id = $cahierTexte->getId();
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->entityManager->remove($cahierTexte);
            $this->entityManager->flush();

            return $this->json($id, Response::HTTP_OK);
        }

        return $this->json(false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @Route("/help", name="application_personnel_carnet_help", methods="GET")
     */
    public function help(): Response
    {
        return $this->render('appPersonnel/carnet/help.html.twig');
    }
}
