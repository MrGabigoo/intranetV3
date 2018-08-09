<?php

namespace App\Controller\superAdministration;

use App\Controller\BaseController;
use App\Entity\Annee;
use App\Entity\Constantes;
use App\Entity\Diplome;
use App\Form\AnneeType;
use App\Repository\AnneeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route({"fr":"super-administration/structure/annee",
 *         "en":"super-administration/organization/year"}
 *)
 */
class AnneeController extends BaseController
{
    /**
     * @Route({"fr":"/", "en":"/"}, name="sa_annee_index", methods="GET")
     * @param AnneeRepository $anneeRepository
     *
     * @return Response
     */
    public function index(AnneeRepository $anneeRepository): Response
    {
        //todo: comment l'exploiter...
        //filtrer par formation ou diplome ?
        return $this->render('structure/annee/index.html.twig', ['annees' => $anneeRepository->findAll()]);
    }

    /**
     * @Route({"fr":"/aide", "en":"/help"}, name="sa_annee_help", methods="GET")
     */
    public function help(): Response
    {
        //todo: comment l'exploiter...
        return $this->render('structure/annee/help.html.twig');
    }

    /**
     * @Route({"fr":"/sauvegarder", "en":"/save"}, name="sa_annee_save", methods="GET")
     * @throws \InvalidArgumentException
     */
    public function save(): Response
    {
        //todo: comment l'exploiter...
        //save en csv
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route({"fr":"/imprimer", "en":"/print"}, name="sa_annee_print", methods="GET")
     * @throws \InvalidArgumentException
     */
    public function imprimer(): Response
    {
        //todo: comment l'exploiter...
        //print (pdf)
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route({"fr":"/nouveau/{diplome}", "en":"/new/{diplome}"}, name="sa_annee_new",
     *                                    methods="GET|POST")
     * @param Request                $request
     *
     * @param Diplome                $diplome
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function create(Request $request, Diplome $diplome)
    {
        if ($diplome->getFormation() !== null) {
            $annee = new Annee();
            $annee->setDiplome($diplome);
            $form = $this->createForm(AnneeType::class, $annee, [
                'formation' => $diplome->getFormation(),
                'attr'      => [
                    'data-provide' => 'validation'
                ]
            ]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->persist($annee);
                $this->entityManager->flush();
                $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'annee.add.success.flash');

                return $this->redirectToRoute(
                    'sa_structure_index',
                    ['formation' => $diplome->getFormation()->getId()]
                );
            }

            return $this->render('structure/annee/new.html.twig', [
                'annee' => $annee,
                'form'  => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('erreur_666');
    }

    /**
     * @Route({"fr":"/{id}", "en":"/{id}"}, name="sa_annee_show", methods="GET")
     * @param Annee $annee
     *
     * @return Response
     */
    public function show(Annee $annee): Response
    {
        return $this->render('structure/annee/show.html.twig', ['annee' => $annee]);
    }

    /**
     * @Route({"fr":"/{id}/modifier", "en":"/{id}/edit"}, name="sa_annee_edit", methods="GET|POST")
     * @param Request                $request
     * @param Annee                  $annee
     *
     * @return Response
     */
    public function edit(Request $request, Annee $annee): Response
    {
        if ($annee->getDiplome() !== null && $annee->getDiplome()->getFormation() !== null) {
            $form = $this->createForm(
                AnneeType::class,
                $annee,
                [
                    'formation' => $annee->getDiplome()->getFormation(),
                    'attr'      => [
                        'data-provide' => 'validation'
                    ]
                ]
            );
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->flush();
                $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'annee.edit.success.flash');

                return $this->redirectToRoute(
                    'sa_structure_index',
                    ['formation' => $annee->getDiplome()->getFormation()->getId()]
                );
            }

            return $this->render('structure/annee/edit.html.twig', [
                'annee' => $annee,
                'form'  => $form->createView(),
            ]);
        }

        return $this->redirectToRoute('erreur_666');
    }

    /**
     * @Route("/{id}/duplicate", name="sa_annee_duplicate", methods="GET|POST")
     * @param Annee                  $annee
     *
     * @return Response
     */
    public function duplicate(Annee $annee): Response
    {
        $newAnnee = clone $annee;

        $this->entityManager->persist($newAnnee);
        $this->entityManager->flush();
        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'annee.duplicate.success.flash');

        return $this->redirectToRoute('sa_annee_edit', ['id' => $newAnnee->getId()]);
    }

    /**
     * @Route({"fr":"/{id}", "en":"/{id}"}, name="sa_annee_delete", methods="DELETE")
     */
    public function delete(): void
    {
    }
}
