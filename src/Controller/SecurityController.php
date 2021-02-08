<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("/security", name="security_")
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/signup", name="signup")
     */
    public function signUp(Request $request, EntityManagerInterface $em, UserPasswordEncoderInterface $encoder)
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(InscriptionType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            // TODO : Supprimer ROLE_ADMIN avant la mise en production
            if (($utilisateur->getUsername() == "admin") && ($utilisateur->getPassword() == "admin"))
            {
                $utilisateur->setRoles(array("ROLE_ADMIN"));
            }
            else
            {
                $utilisateur->setRoles(array("ROLE_USER"));
            }

            $utilisateur->setPassword($encoder->encodePassword($utilisateur, $utilisateur->getPassword()));

            $em->persist($utilisateur);
            $em->flush();

            return $this->redirectToRoute("aliment_view_all");
        }

        return $this->render('security/signup.html.twig', [
            "form" => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $util)
    {
        return $this->render("security/login.html.twig", [
            "lastUserName" => $util->getLastUsername(),
            "error" => $util->getLastAuthenticationError()
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }
}
