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
        /* make curl request */ 
        $ch = curl_init();
        $id_article = $request->get('id');
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/lab5RestApi/web/app_dev.php/api/articles/'.$id_article);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $data = json_decode($response);
        
        return $this->render('RestClientBundle:article:suppArticle.html.twig', array(
            'articles' => $data,
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
            
            $api_request_url = 'http://localhost/lab5RestApi/web/app_dev.php/api/articles';
            
            $api_request_parameters = array(
                'titre' => $request->get('titre'),
                'leadings' => $request->get('titre'),
                'body'   => $request->get('body'),
                'slug' => $request->get('slug'),
                'created_by' => $request->get('auteur')
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            /*
            if ($method_name == 'DELETE')
            {
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
              curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
            }*/

            
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
            
            /*
            if ($method_name == 'PUT')
            {
              curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
              curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_request_parameters));
            */

            /*
              Here you can set the Response Content Type you prefer to get :
              application/json, application/xml, text/html, text/plain, etc
            */
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/json'));

            /*
              Let's give the Request Url to Curl
            */
            curl_setopt($ch, CURLOPT_URL, $api_request_url);

            /*
              Yes we want to get the Response Header
              (it will be mixed with the response body but we'll separate that after)
            */
            curl_setopt($ch, CURLOPT_HEADER, TRUE);
            /*
              Allows Curl to connect to an API server through HTTPS
            */
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
            $api_response = curl_exec($ch);
            $api_response_info = curl_getinfo($ch);
            curl_close($ch);

            //$api_response_header = trim(substr($api_response, 0, $api_response_info['header_size']));
            $api_response_body = substr($api_response, $api_response_info['header_size']);

            //echo $api_response_info['http_code'];
            echo $api_response_body;
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
             
        }
        
        return $this->render('RestClientBundle:article:ajouterArticle.html.twig', array(
      
        ));
    }
}
