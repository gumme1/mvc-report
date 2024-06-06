<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Card\Deck;
use App\Controller\Card\Card;
use App\Controller\Card\CardGraphic;

class ApiCardController extends AbstractController
{
    #[Route('/api/deck', name: 'api_deck', methods: ['GET'])]
    public function getDeck(SessionInterface $session): JsonResponse
    {
        // // $deck = new Deck();
        // $deck = $session->get('deck', new Deck());
        // $cards = $deck->getCards();

        // // Sort cards by suit and value
        // usort($cards, function ($a, $b) {
        //     $suitsOrder = ['Hearts', 'Diamonds', 'Clubs', 'Spades'];
        //     $aSuitOrder = array_search($a->getSuitCard(), $suitsOrder);
        //     $bSuitOrder = array_search($b->getSuitCard(), $suitsOrder);

        //     if ($aSuitOrder === $bSuitOrder) {
        //         return $a->getValueCard() <=> $b->getValueCard();
        //     }

        //     return $aSuitOrder <=> $bSuitOrder;
        // });

        // $sortedDeck = [];
        // foreach ($cards as $card) {
        //     $sortedDeck[] = [
        //         'suit' => $card->getSuitCard(),
        //         'value' => $card->getValueCard()
        //     ];
        // }

        // return new JsonResponse($sortedDeck);

        if ($session->has('deck')) {
            $deck = $session->get('deck');
        } else {
            $deck = new Deck();
            $session->set('deck', $deck);
        }

        $cards = [];
        foreach ($deck->getCards() as $card) {
            $cardGraphic = new CardGraphic();
            $cardGraphic->setSuit($card->getSuitCard());
            $cardGraphic->setValue($card->getValueCard());
            $cards[] = $cardGraphic->getAsString();
        }

        return new JsonResponse($cards);
    }

    #[Route('/api/deck/shuffle', name: 'api_deck_shuffle')]
    public function shuffleDeck(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck', new Deck());
        $deck->shuffle();
        $session->set('deck', $deck);

        $shuffledDeck = [];
        foreach ($deck->getCards() as $card) {
            $shuffledDeck[] = [
                'suit' => $card->getSuitCard(),
                'value' => $card->getValueCard()
            ];
        }

        return new JsonResponse($shuffledDeck);
        // return $this->redirectToRoute('api_deck');
    }

    #[Route('/api/deck/draw', name: 'api_deck_draw')]
    public function drawCard(SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck');

        $drawnCard = $deck->draw()[0];
        $cardGraphic = new CardGraphic();
        $cardGraphic->setSuit($drawnCard->getSuitCard());
        $cardGraphic->setValue($drawnCard->getValueCard());
        $card = $cardGraphic->getAsString();

        $session->set('deck', $deck);

        return new JsonResponse($card);
    }

    #[Route('/api/deck/draw/{num<\d+>}', name: 'api_deck_draw_num')]
    public function drawCards(int $num, SessionInterface $session): JsonResponse
    {
        $deck = $session->get('deck');

        $numberOfCards = count($deck->getCards());
        if ($num > $numberOfCards) {
            throw new \Exception("Can not draw more than 52 cards!");
        }

        $cards = [];

        for ($i = 1; $i <= $num; $i++) {
            $drawnCard = $deck->draw()[0];
            $cardGraphic = new CardGraphic();
            $cardGraphic->setSuit($drawnCard->getSuitCard());
            $cardGraphic->setValue($drawnCard->getValueCard());
            $cards[] = $cardGraphic->getAsString();
        }

        $session->set('deck', $deck);

        $remainingCards = count($deck->getCards());
        $data = [
            "num_cards" => count($cards),
            "cardDraw" => $cards,
            "cards_left" => $remainingCards,
        ];
        // return $this->render('card/test/draw_many.html.twig', $data);

        return new JsonResponse($data);
    }
}
