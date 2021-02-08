<?php

namespace App\Controller;

use App\Repository\AlimentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/aliment", name="aliment_")
 */
class AlimentController extends AbstractController
{
    /**
     * @Route("/", name="view_all")
     *
     * @param AlimentRepository $repository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAll(AlimentRepository $repository)
    {
        $aliments = $repository->findAll();
        return $this->render('aliment/view_all.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => false
        ]);
    }

    /**
     * @Route("/calorie/{calorie}", name="view_all_calory")
     *
     * @param AlimentRepository $repository
     * @param $calorie
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllByCalory(AlimentRepository $repository, $calorie)
    {
        $aliments = $repository->getAlimentParPropriete('calorie','<', $calorie);

        return $this->render('aliment/view_all.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => true,
            'calorie' => $calorie,
            'isGlucide' => false
        ]);
    }

    /**
     * @Route("/glucide/{glucide}", name="view_all_glucide")
     *
     * @param AlimentRepository $repository
     * @param $glucide
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAllByGlucide(AlimentRepository $repository, $glucide)
    {
        $aliments = $repository->getAlimentParPropriete('glucide','<', $glucide);

        return $this->render('aliment/view_all.html.twig', [
            'aliments' => $aliments,
            'isCalorie' => false,
            'isGlucide' => true,
            'glucide' => $glucide
        ]);
    }
}
