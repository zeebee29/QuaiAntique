<?php

namespace App\Controller;

use App\Entity\OuvertureHebdo;
use App\Repository\OuvertureHebdoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FooterController extends AbstractController
{
    public function plageOuverture(OuvertureHebdoRepository $ouvertureHebdoRepository): Response
    {
        $heures = $ouvertureHebdoRepository->findAll();
        dd($heures);

        return $this->render('partial/_horaires.html.twig', [
            'heures' => $heures,
        ]);
    }
}
