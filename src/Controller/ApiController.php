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

    // #[Route('/api', name: 'api')]
    // public function api(): Response
    // {

    //     $routes = $this->router->getRouteCollection()->all();

    //     $routeDescriptions = [
    //         '/api/card/deck' => 'Returns a list of all cards in the deck.',
    //         '/api/card/deck/shuffle' => 'Shuffles the deck and returns the shuffled deck.',
    //         '/api/card/deck/draw' => 'Draws a single card from the deck.',
    //         '/api/card/deck/draw/{num}' => 'Draws the specified number of cards from the deck.',
    //     ];

    //     $jsonRoutes = [];
    //     foreach ($routes as $route) {
    //         if (strpos($route->getPath(), '/api/') === 0) {
    //             $jsonRoutes[] = [
    //                 'path' => $route->getPath(),
    //                 'method' => implode('|', $route->getMethods()),
    //                 'description' => $routeDescriptions[$route->getPath()] ?? 'No description available',
    //             ];
    //         }
    //     }

    //     var_dump($jsonRoutes);

    //     return $this->render('api.html.twig', [
    //         'jsonRoutes' => $jsonRoutes,
    //     ]);
    // }

    #[Route('/api', name: 'api')]
    public function api(): Response
    {
        $routes = $this->router->getRouteCollection()->all();

        $routeDescriptions = [
            '/api' => 'Returns all routes and a description.',
            '/api/quote' => 'Returns a random quote and some info.',
            '/api/lucky/number' => 'Returns a lucky number.',
            '/api/card/deck' => 'Returns a list of all cards in the deck.',
            '/api/card/deck/shuffle' => 'Shuffles the deck and returns the shuffled deck.',
            '/api/card/deck/draw' => 'Draws a single card from the deck.',
            '/api/card/deck/draw/{num}' => 'Draws the specified number of cards from the deck.',
            '/card' => 'The start site for the card game.',
            '/card/deck' => 'Shows the whole deck of cards left.',
            '/card/deck/shuffle' => 'Shuffles the cards in the deck.',
            '/card/deck/draw' => 'Draws one card from the deck.',
            '/card/deck/draw/{num}' => 'Draws {num} cards from the deck.',
            '/session' => 'Shows the info of the session.',
            '/session/delete' => 'Resets the session.',
            '/about' => 'about page for the report site.',
            '/report' => 'report page for the site.',
            // Lägg till fler beskrivningar här
        ];

        $jsonRoutes = [];
        foreach ($routes as $name => $route) {
            if (strpos($route->getPath(), '/_') === 0 || strpos($route->getPath(), '/bundles/') === 0) {
                continue;
            }

            $jsonRoutes[] = [
                'path' => $route->getPath(),
                'method' => implode('|', $route->getMethods()),
                'description' => $routeDescriptions[$route->getPath()] ?? 'No description available',
            ];
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
