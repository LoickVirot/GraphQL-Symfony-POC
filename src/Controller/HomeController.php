<?php

namespace App\Controller;

use App\Service\GraphQLCaller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param GraphQLCaller $graphQLCaller
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \GraphQL\Server\RequestError
     */
    public function index(GraphQLCaller $graphQLCaller)
    {
        $query =
"{
    movies {
        id
        title
        resume
        categories {
            title
        }
    }
}";

        $result = $graphQLCaller
            ->setQuery($query)
            ->send()
        ;

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'movies' => $result->data->movies
        ]);
    }
}
