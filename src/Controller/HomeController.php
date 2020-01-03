<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        // Get data
        $url = 'https://testgraphql.local/api/graphql/';

        $query = [
            "query" => "{
                movies {
                    id
                    title
                    resume
                    categories {
                        title
                    }
                }
            }",
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($query));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        // DEVELOP ONLY
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        // END DEVELOP ONLY
        $result = json_decode(curl_exec($ch));

        if (curl_errno($ch)) {
            dump(curl_error($ch));die;
        }

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'movies' => $result->data->movies
        ]);
    }
}
