<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use BlogBundle\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *@Route("/user")
 */
class UserController extends Controller
{
    /**
     *@Route("/add")
     */
    public function addUser(){
        $user= new User();
        $user->setName("Usuario");
        $user->setEmail("mail2@mail.com");
        $em=$this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return new Response("Usuario creado ->".$user->getName() );
    }
}
