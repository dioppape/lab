<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les 
use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;

class ArticleController extends Controller
{
    /**
     * @Rest\View()
     * @Rest\Get("/api/articles")
     */
    public function getArticleAction(Request $request)
    {
        $articles = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Article')
            ->findAll();
        
        if (empty($articles)) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }
        
        return $articles;
    }
    
    
    /**
     * @Rest\View()
     * @Rest\Get("/api/articles/{id}")
     */
    public function getOneArticleAction(Request $request) {
        $article = $this->get('doctrine.orm.entity_manager')
            ->getRepository('AppBundle:Article')
            ->find($request->get('id'));
        if (empty($article)) {
            return new JsonResponse(['message' => 'This Article is not found'], Response::HTTP_NOT_FOUND);
        }
        return $article;
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/api/articles")
     */
    public function postArticleAction(Request $request) {
        $article = new Article();
        /* call later by service 
        $form = $this->createForm('task', $article); 
        */
        $form = $this->createForm(ArticleType::class, $article);
        $form -> submit($request->request->All());
        
        if ($request->isMethod('Post')) {
            $em = $this->get('doctrine.orm.entity_manager');
            $article->setCreatedAt(new \Datetime());
            $em->persist($article);
            $em->flush();
            return $article;
        } else {
            return $form;
        }
    }
    
    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/api/articles/{id}")
     */
    public function removeArticleAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $article = $em->getRepository('AppBundle:Article')
                    ->find($request->get('id'));
        /* @var $place Place */
    
        if (!$article) {
           return new JsonResponse(['message' => 'This Article is not found'], Response::HTTP_NOT_FOUND);
        }

        $em->remove($article);
        $em->flush();
        
        /* return a message and status_code when success */
        return new JsonResponse(['message' => 'Article removed successfully']);
    }
}
