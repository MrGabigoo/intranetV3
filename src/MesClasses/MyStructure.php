<?php
/**
 * Created by PhpStorm.
 * User: davidannebicque
 * Date: 09/08/2018
 * Time: 17:19
 */

namespace App\MesClasses;


use App\Entity\Constantes;
use App\Entity\Formation;
use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class MyStructure
{
    /** @var Formation */
    protected $formation;

    /** @var EngineInterface */
    protected $templating;

    /**
     * MyStructure constructor.
     *
     * @param EngineInterface $templating
     */
    public function __construct(EngineInterface $templating)
    {
        $this->templating = $templating;
    }


    public function export(Formation $formation, $_format): void
    {
        $this->formation = $formation;

        switch ($_format) {
            case 'pdf':
                //template PDF prêt.
                $html = $this->templating->render('pdf/structure.html.twig', array(
                    'formation' => $formation,
                    'linuxpath' => Constantes::BASE_URL
                ));

                $options = new \Dompdf\Options();
                $options->set('isRemoteEnabled', TRUE);
                $options->set('isPhpEnabled', TRUE);

                $dompdf = new Dompdf($options);
                $dompdf->loadHtml($html);
                $dompdf->render();

                $dompdf->stream('structure_formation', array('Attachment' => 1));
                break;
            case 'xlsx':

                break;
        }
    }
}