<?php

namespace App\Controller\appPersonnel;

use App\Controller\BaseController;
use App\Entity\Evaluation;
use App\Entity\Matiere;
use App\Form\EvaluationType;
use App\MesClasses\MyEvaluations;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class NotesController
 * @package App\Controller
 * @Route({"fr":"application/personnel/note",
 *         "en":"application/team/mark"}
 *)
 * @IsGranted("ROLE_PERMANENT")
 */
class NoteController extends BaseController
{
    /**
     * @Route("/{matiere}", name="application_personnel_note_index", requirements={"matiere"="\d+"})
     * @param MyEvaluations $myEvaluations
     * @param Matiere       $matiere
     *
     * @return Response
     */
    public function index(MyEvaluations $myEvaluations, Matiere $matiere): Response
    {
        $myEvaluations->setMatiere($matiere);
        $myEvaluations->getEvaluationsMatiere($this->dataUserSession->getAnneeUniversitaire());

        return $this->render('appPersonnel/note/index.html.twig', [
            'matiere'     => $matiere,
            'evaluations' => $myEvaluations,
            'indexEval'   => 0 //todo à prendre en parametre
        ]);
    }

    /**
     * @Route("/evaluation/{evaluation}", name="application_personnel_evaluation_show",
     *                                    requirements={"evaluation"="\d+"})
     *
     * @return Response
     */
    public function detailsEvaluation(Evaluation $evaluation): Response
    {
        return $this->render('appPersonnel/note/saisie_2.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * @Route("/saisie/etape-1/{matiere}", name="application_personnel_note_saisie", requirements={"matiere"="\d+"})
     * @param Request                $request
     * @param Matiere                $matiere
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function saisie(Request $request, Matiere $matiere)
    {
        if ($matiere !== null && $matiere->getUe() !== null) {
            $evaluation = new Evaluation($this->getUser(), $matiere, $this->dataUserSession->getFormation());
            $form = $this->createForm(EvaluationType::class, $evaluation,
                [
                    'formation'       => $this->dataUserSession->getFormation(),
                    'semestre'        => $matiere->getUe()->getSemestre(),
                    'matiereDisabled' => true,
                    'attr'            => [
                        'data-provide' => 'validation'
                    ]
                ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->persist($evaluation);
                $this->entityManager->flush();

                return $this->redirectToRoute('application_personnel_note_saisie_2',
                    ['evaluation' => $evaluation->getId()]);
            }

            return $this->render('appPersonnel/note/saisie.html.twig', [
                'matiere' => $matiere,
                'form'    => $form->createView()
            ]);
        }

        return $this->redirectToRoute('erreur_666');
    }

    /**
     * @Route("/saisie/etape-2/{evaluation}", name="application_personnel_note_saisie_2",
     *                                        requirements={"matiere"="\d+"})
     * @param Request    $request
     * @param Evaluation $evaluation
     *
     * @return Response
     */
    public function saisieNotes(Request $request, Evaluation $evaluation)
    {
        return $this->render('appPersonnel/note/saisie_2.html.twig', [
            'evaluation' => $evaluation,
        ]);
    }

    /**
     * @Route("/import/{matiere}", name="application_personnel_note_import", requirements={"matiere"="\d+"})
     * @param Matiere $matiere
     *
     * @return Response
     */
    public function import(Request $request, Matiere $matiere)
    {
        $evaluation = new Evaluation($this->getUser(), $matiere, $this->dataUserSession->getFormation());
        $form = $this->createForm(EvaluationType::class, $evaluation,
            [
                'formation'       => $this->dataUserSession->getFormation(),
                'semestre'        => $matiere->getUe()->getSemestre(),
                'import'          => true,
                'matiereDisabled' => true,
                'attr'            => [
                    'data-provide' => 'validation'
                ]
            ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) { //&& $form->isValid()
            //dump($request->files);
            $this->entityManager->persist($evaluation);
            $this->entityManager->flush();


            //traitement de l'import des notes.

            //return $this->redirectToRoute('application_personnel_note_confirme_import',
            //    ['evaluation' => $evaluation->getId()]);
        }

        return $this->render('appPersonnel/note/import.html.twig', [
            'matiere' => $matiere,
            'form'    => $form->createView()
        ]);
    }


    /**
     * @Route("/aide", name="application_personnel_note_help", methods="GET")
     */
    public function help(): Response
    {
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/save/{evaluation}", name="application_personnel_note_save", methods="GET")
     */
    public function save(): Response
    {
        //save en csv
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/imprimer/{evaluation}", name="application_personnel_note_imprimer", methods="GET")
     */
    public function imprimer(): Response
    {
        //print (pdf)
        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/{id}", name="application_personnel_Note_delete", methods="DELETE")
     */
    public function supprimer(): Response
    {
        return new Response('', Response::HTTP_OK);
    }
}
