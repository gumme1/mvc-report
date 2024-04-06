<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface; // Importera RouterInterface

class ApiController extends AbstractController
{
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    #[Route('/api', name: 'api')]
    public function api(): Response
    {

        $routes = $this->router->getRouteCollection()->all();

        $jsonRoutes = [];
        foreach ($routes as $route) {
            if (strpos($route->getPath(), '/api/') === 0) {
                $jsonRoutes[] = [
                    'path' => $route->getPath(),
                    'method' => implode('|', $route->getMethods()),
                ];
            }
        }

        return $this->render('api.html.twig', [
            'jsonRoutes' => $jsonRoutes,
        ]);
    }

    #[Route('/api/quote', name: 'api_quote')]
    public function quote(): Response
    {
        $quotes = [
            "Float like a butterfly, sting like a bee.",
            "I think, therefore I am",
            "To be or not to be, that is the question."
        ];

        $randomQuote = $quotes[array_rand($quotes)];

        $date = date('Y-m-d');
        $timestamp = time();

        $response = new JsonResponse([
            'quote' => $randomQuote,
            'date' => $date,
            'timestamp' => $timestamp
        ]);

        return $response;
    }
}