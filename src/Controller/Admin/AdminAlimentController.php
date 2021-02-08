<?php

namespace App\Controller\Admin;

use App\Entity\Aliment;
use App\Form\AlimentType;
use App\Repository\AlimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/aliment", name="admin_aliment_")
 */
class AdminAlimentController extends AbstractController
{
    /**
     * @Route("/", name="view_all")
     */
    public function getAll(AlimentRepository $respository)
    {
        $aliments = $respository->findAll();
        return $this->render('admin/aliment/admin_viewAll.html.twig',[
            "aliments" => $aliments
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @Route("/{id}", name="update", methods="GET|POST")
     */
    public function addOrUpdate(Request $request, EntityManagerInterface $em, Aliment $aliment = null)
    {
        if(!$aliment) {
            $aliment = new Aliment();
        }

        $form = $this->createForm(AlimentType::class, $aliment);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $modif = $aliment->getId() !== null;
            $em->persist($aliment);
            $em->flush();
            $this->addFlash("success", ($modif) ? "La modification a été effectuée" : "L'ajout a été effectuée");
            return $this->redirectToRoute("admin_aliment_view_all");
        }

        return $this->render('admin/aliment/admin_addOrUpdate.html.twig',[
            "aliment" => $aliment,
            "form" => $form->createView(),
            "isModification" => $aliment->getId() !== null
        ]);
    }

     /**
     * @Route("/{id}", name="delete", methods="delete")
     */
    public function delete(Aliment $aliment, Request $request, EntityManagerInterface $em){
        if($this->isCsrfTokenValid("supprimer" . $aliment->getId(), $request->get('_token'))){
            $em->remove($aliment);
            $em->flush();
            $this->addFlash("success","La suppression a été effectuée");
        }

        return $this->redirectToRoute("admin_aliment_view_all");
    }
}
