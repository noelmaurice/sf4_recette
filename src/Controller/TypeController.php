<?php

namespace App\Controller;

use App\Repository\TypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/type", name="type_")
 */
class TypeController extends AbstractController
{
    /**
     * @Route("/", name="view_all")
     */
    public function getAll(TypeRepository $repository)
    {
        $types = $repository->findAll();

        return $this->render('type/types.html.twig',[
            "types" => $types
        ]);
    }
}
