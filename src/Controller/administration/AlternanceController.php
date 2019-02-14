<?php

namespace App\Controller\administration;

use App\Controller\BaseController;
use App\Entity\Alternance;
use App\Entity\Annee;
use App\Entity\Constantes;
use App\Entity\Etudiant;
use App\Entity\Personnel;
use App\Form\AlternanceType;
use App\MesClasses\MyExport;
use App\Repository\AlternanceRepository;
use App\Repository\EtudiantRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/administration/alternance")
 */
class AlternanceController extends BaseController
{
    /**
     * @Route("/{annee}", name="administration_alternance_index", methods="GET")
     * @param EtudiantRepository   $etudiantRepository
     * @param AlternanceRepository $alternanceRepository
     * @param Annee                $annee
     *
     * @return Response
     */
    public function index(
        EtudiantRepository $etudiantRepository,
        AlternanceRepository $alternanceRepository,
        Annee $annee
    ): Response {
        $etudiants = $etudiantRepository->findByAnnee($annee);

        return $this->render('administration/alternance/index.html.twig',
            [
                'alternances' => $alternanceRepository->findByAnneeArray($annee,
                    $annee->getAnneeUniversitaire()),
                'annee'       => $annee,
                'etudiants'   => $etudiants,
            ]);
    }

    /**
     * @Route("/init/all/{annee}", name="administration_alternance_init_all")
     * @param EtudiantRepository $etudiantRepository
     * @param Annee              $annee
     *
     * @return RedirectResponse
     */
    public function initAll(EtudiantRepository $etudiantRepository, Annee $annee): RedirectResponse
    {
        $etudiants = $etudiantRepository->findByAnnee($annee);
        //todo: faudrait vérifier si existe pas déjà ...
        foreach ($etudiants as $etudiant) {
            $alternance = new Alternance();
            $alternance->setEtudiant($etudiant);
            $alternance->setAnneeUniversitaire($annee->getAnneeUniversitaire());
            $alternance->setAnnee($annee);
            $alternance->setEtat('init');
            $this->entityManager->persist($alternance);
        }

        $this->entityManager->flush();

        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'alternance.init.all.success.flash');

        return $this->redirectToRoute('administration_alternance_index', ['annee' => $annee->getId()]);
    }

    /**
     * @param Etudiant $etudiant
     * @param          $action
     * @param Annee    $annee
     *
     * @return RedirectResponse
     * @Route("/init/{annee}/{action}/{etudiant}", name="administration_alternance_init")
     */
    public function init(Etudiant $etudiant, $action, Annee $annee): RedirectResponse
    {
        $alternance = new Alternance();
        $alternance->setEtudiant($etudiant);
        $alternance->setAnneeUniversitaire($annee->getAnneeUniversitaire());
        $alternance->setAnnee($annee);

        if ($action === 'init-false') {
            $alternance->setEtat('sans');
        } else {
            $alternance->setEtat('init');
        }

        $this->entityManager->persist($alternance);
        $this->entityManager->flush();

        $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'alternance.init.one.success.flash');

        return $this->redirectToRoute('administration_alternance_index', ['annee' => $annee->getId()]);
    }


    /**
     * @Route("/export/{annee}.{_format}", name="administration_alternance_export", methods="GET",
     *                                     requirements={"_format"="csv|xlsx|pdf"})
     * @param MyExport             $myExport
     * @param AlternanceRepository $alternanceRepository
     * @param Annee                $annee
     * @param                      $_format
     *
     * @return Response
     * @throws \PhpOffice\PhpSpreadsheet\Exception
     */
    public function export(
        MyExport $myExport,
        AlternanceRepository $alternanceRepository,
        Annee $annee,
        $_format
    ): Response {
        $actualites = $alternanceRepository->findByAnnee($annee, $annee->getAnneeUniversitaire());
        $response = $myExport->genereFichierGenerique(
            $_format,
            $actualites,
            'alternances',
            ['alternances_administration', 'utilisateur'],
            ['titre', 'texte', 'formation' => ['libelle']]//todo: a parametrer avec alternance
        );

        return $response;
    }

    /**
     * @Route("/new", name="administration_alternance_new", methods="GET|POST")
     * @param Request $request
     *
     * @return Response
     */
    public function create(Request $request): Response
    {
        $alternance = new Alternance();
        $form = $this->createForm(AlternanceType::class, $alternance, ['formation' => $this->dataUserSession->getFormation()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($alternance);
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'alternance.add.success.flash');

            return $this->redirectToRoute('administration_alternance_index');
        }

        return $this->render('administration/alternance/new.html.twig', [
            'alternance' => $alternance,
            'form'       => $form->createView(),
        ]);
    }

    /**
     * @Route("/details/{id}", name="administration_alternance_show", methods="GET")
     * @param Alternance $alternance
     *
     * @return Response
     */
    public function show(Alternance $alternance): Response
    {
        return $this->render('administration/alternance/show.html.twig', ['alternance' => $alternance]);
    }

    /**
     * @Route("/{id}/edit", name="administration_alternance_edit", methods="GET|POST")
     * @param Request    $request
     * @param Alternance $alternance
     *
     * @return Response
     */
    public function edit(Request $request, Alternance $alternance): Response
    {
        $form = $this->createForm(AlternanceType::class, $alternance, ['formation' => $this->dataUserSession->getFormation()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();
            $this->addFlashBag(Constantes::FLASHBAG_SUCCESS, 'alternance.edit.success.flash');

            return $this->redirectToRoute('administration_alternance_edit', ['id' => $alternance->getId()]);
        }

        return $this->render('administration/alternance/edit.html.twig', [
            'alternance' => $alternance,
            'form'       => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="administration_alternance_delete", methods="DELETE")
     * @param Request    $request
     * @param Alternance $alternance
     *
     * @return Response
     */
    public function delete(Request $request, Alternance $alternance): Response
    {
        $id = $alternance->getId();
        if ($this->isCsrfTokenValid('delete' . $id, $request->request->get('_token'))) {
            $this->entityManager->remove($alternance);
            $this->entityManager->flush();
            $this->addFlashBag(
                Constantes::FLASHBAG_SUCCESS,
                'alternance.delete.success.flash'
            );

            return $this->json($id, Response::HTTP_OK);
        }

        $this->addFlashBag(Constantes::FLASHBAG_ERROR, 'alternance.delete.error.flash');

        return $this->json(false, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    /**
     * @param Alternance $alternance
     * @param Personnel  $personnel
     * @Route("/update/tuteur-universitaire/{alternance}/{personnel}", name="administration_alternance_update_tuteur_universitaire")
     *
     * @return JsonResponse
     */
    public function updateTuteurUniversitaire(Alternance $alternance, Personnel $personnel): JsonResponse
    {
        $alternance->setTuteurUniversitaire($personnel);
        $this->entityManager->persist($alternance);
        $this->entityManager->flush();

        return $this->json('ok', 200);
    }
}