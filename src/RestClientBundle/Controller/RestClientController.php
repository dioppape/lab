<?php

namespace RestClientBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Buzz\Message\Form;

class RestClientController extends Controller
{
    
    /**
     * @Route("/articles/{id}", name="delete_article")
     */
    public function editerAction(Request $request)
    {
        /*
         {
  "id": 1,
  "titre": "test",
  "leadings": "1",
  "body": "blbla",
  "created_at": "2016-10-25T23:48:17+0200",
  "slug": "125",
  "created_by": "12-12-2000"
}
         */
        /* make curl request
        $ch = curl_init();
        $id_article = $request->get('id');
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/lab5RestApi/web/app_dev.php/api/articles/'.$id_article);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response);*/
        $postData = '';
        //create name value pairs seperated by &
        $params = array(
            "titre" => "Ravishanker Kusuma",
            "leadings" => "1",
            "body" => "test lab",
            "slug" => "152",
            "createdBy" => "02-01-2016"
        );
        $url = $this->getUrl();
        foreach($params as $k => $v)
        {
            $postData .= $k . '='.$v.'&';
        }
        $postData = rtrim($postData, '&');

        $ch = curl_init();

        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, count($postData));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

        $output=curl_exec($ch);

        curl_close($ch);
        dump($output);die;

        
        return $this->render('RestClientBundle:article:suppArticle.html.twig', array(
            'articles' => $output,
        ));
    }
    
    /**
     * @Route("/", name="all_articles")
     */
    public function listArticlesAction(Request $request)
    {
        /* make curl request */ 
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/lab5RestApi/web/app_dev.php/api/articles');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response, true);

        return $this->render('RestClientBundle:article:listerArticle.html.twig', array(
            'articles' => $data,
        ));
    }

    /**
     * @Route("/creer", name="add_article")
     */
    public function creerArticlesAction(Request $request)
    {
        if ($request->isMethod('Post')) {

            $url = $this->getUrl();//'http://localhost/lab5RestApi/web/app_dev.php/api/articles';
            $postData = '';
            $params = array(
                'titre' => $request->get('titre'),
                'leadings' => $request->get('titre'),
                'body' => $request->get('body'),
                'slug' => $request->get('slug'),
                'createdBy' => $request->get('auteur')
            );
            foreach ($params as $k => $v) {
                $postData .= $k . '=' . $v . '&';
            }
            $postData = rtrim($postData, '&');

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, count($postData));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

            $output = curl_exec($ch);

            curl_close($ch);
            /*
            //trying with ci/restclientbundle
            $restClient = $this->container->get('circle.restclient');
            $opts = array(
                    'titre' => $request->get('titre'),
                    'leadings' => $request->get('titre'),
                    'body'   => $request->get('body'),
                    'slug' => 'user-5',
                    'created_by' => $request->get('auteur')
                );
            $restClient->post('http://localhost/lab5RestApi/web/app_dev.php/api/articles', $opts);*/


            return $this->render('RestClientBundle:article:ajouterArticle.html.twig', json_decode($output, true));
        }
        return $this->render('RestClientBundle:article:ajouterArticle.html.twig', ['status' => 401]);
    }

    public function getUrl() {
        return "http://localhost/lab5RestApi/web/app_dev.php/api/articles";//http://lab.dev/app_dev.php/api/articles";
    }
}
