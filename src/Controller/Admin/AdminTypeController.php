<?php

namespace App\Controller\Admin;

use App\Entity\Type;
use App\Form\TypeType;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/type", name="admin_type_")
 */
class AdminTypeController extends AbstractController
{
    /**
     * @Route("/", name="view_all")
     */
    public function index(TypeRepository $repository)
    {
        $types = $repository->findAll();

        return $this->render('admin/type/admin_viewAll.html.twig',[
            "types" => $types
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @Route("/{id}", name="update", methods="POST|GET")
     */
    public function addOrUpdate(Request $request, EntityManagerInterface $em, Type $type = null)
    {
        if(!$type)
        {
            $type = new Type();
        }

        $form = $this->createForm(TypeType::class, $type);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $em->persist($type);
            $em->flush();
            $this->addFlash('success', "L'action a été réalisée");
            return $this->redirectToRoute("admin_type_view_all");
        }

        return $this->render('admin/type/admin_addOrUpdate.html.twig',[
            "type" => $type,
            "form" => $form->createView(),
            "isModification" => $type->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="delete", methods="delete")
     */
    public function delete(Type $type, EntityManagerInterface $em, Request $request)
    {
       if($this->isCsrfTokenValid('supprimer' . $type->getId(), $request->get('_token'))){
           $em->remove($type);
           $em->flush();
           $this->addFlash('success', "L'action a été réalisée");
       }

        return $this->redirectToRoute("admin_type_view_all");
    }
}
