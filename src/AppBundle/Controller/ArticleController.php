<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations

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
}
