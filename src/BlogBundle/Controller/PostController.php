<?php

namespace BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use BlogBundle\Entity\Post;

/**
 * @Route("/post")
 */
class PostController extends Controller
{

    /**
     * @Route("/add")
     */
    public function addAction(){
       
        //Recuperamos el Entity Manager
        $em = $this->getDoctrine()->getManager();
        
        //Creamos la entidad
        $post = new Post(); 
        $post->setTitle('Prueba1');
        $post->setBody('Es el cuerpo mas largo para otro post ');
        $post->setTag('untag');
        $post->setCreateAt(new \DateTime('now'));

        //Persistimos la entidad

        $em->persist($post);
        $em->flush();


        return new Response("Retorno post creado ->".$post->getId());

    }


    /**
     * @Route("/getAll")
     */
    public function getAllAction(){

        //Recuperar el Manager
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('BlogBundle:Post');
        $posts = $repository->findAll();
        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$posts]);
    }
    /**
     * @Route("/getallfilter")
     */
    public function getAllFilterAction(){

        //Recuperar el Manager
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p FROM BlogBundle:Post p'
        );
        $posts = $query->getResult();
        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$posts]);
    }

    /**
     * @Route("/find/{id}")
     */
    public function getPostById($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository("BlogBundle:Post");
        $post = $repository->find($id);
        return $this->render('@Blog/Default/post.html.twig',['post'=>$post]);
    }

      /**
     * @Route("/findtitle/{title}")
     */
    public function getPostByTitle($title)
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository("BlogBundle:Post");
        $post = $repository->findByTitle($title);
        if(!$post){
            return new Response("No existe ningun registro con ese nombre");
        }
        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$post]);
    }

     /**
     * @Route("/findquery/{title}")
     */
    public function getPostByTitleQuery($title)
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository("BlogBundle:Post");
        $query= $repository->createQueryBuilder('p')
            ->where('title = %ue%')->getQuery();
        $post = $query->getResult();
        if(!$post){
            return new Response("No existe ningun registro con ese nombre");
        }
        return $this->render('@Blog/Default/posts.html.twig',['posts'=>$post]);
    }


    /**
     * @Route("/updatepost/{id}")
     */
    public function updatePost($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository("BlogBundle:Post");
        $post= $repository->find($id);
        if(!$post){
            return new Response("No existe ningun registro con ese nombre");
        }
        $post->setTitle("Titulo cambiado");
        $em->flush();
        return new Response("Post actualizado ->");
    }


    /**
     * @Route("/deletepost/{id}")
     */
    public function getDelete()
    {
        $em = $this->getDoctrine()->getManager();
        $repository= $em->getRepository("BlogBundle:Post");
        $post= $repository->find($id);
        if(!$post){
            return new Response("No existe el post");
        }
        $em->remove($post);
        $em->flush();
        return new Response("Post eliminado");
    }


}
