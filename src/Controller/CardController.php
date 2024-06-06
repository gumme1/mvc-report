<?php

namespace App\Controller;

use App\Controller\Card\Card;
use App\Controller\Card\CardGraphic;
// use App\Controller\Card\CardHand;
use App\Controller\Card\Deck;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardController extends AbstractController
{
    #[Route('/card', name: 'landing_page')]
    public function LandingPage(): Response
    {
        return $this->render('card/landing_page.html.twig');
    }

    #[Route('/card/deck', name: 'card_deck')]
    public function showCardDeck(SessionInterface $session): Response
    {
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

        return $this->render('card/deck.html.twig', [
            'cards' => $cards,
        ]);
    }

    #[Route('/card/deck/shuffle', name: 'shuffle')]
    public function shuffleCardDeck(SessionInterface $session): Response
    {
        // $deck = $session->get('deck');
        $deck = new Deck();
        $deck->shuffle();
        $session->set('deck', $deck);

        return $this->redirectToRoute('card_deck');
    }

    // #[Route('/card/deck/draw', name: 'draw_number')]
    // public function drawCardDeck(SessionInterface $session): Response
    // {
    //     $card = new Card();

    //     $data = [
    //         "card" => $card->draw(),
    //         "cardString" => $card->getAsStringCard(),
    //     ];

    //     return $this->render('card/test/draw.html.twig', $data);
    // }

    #[Route('/card/deck/draw', name: 'draw')]
    public function drawCardDeck(SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        $drawnCard = $deck->draw()[0];
        $cardGraphic = new CardGraphic();
        $cardGraphic->setSuit($drawnCard->getSuitCard());
        $cardGraphic->setValue($drawnCard->getValueCard());
        $card = $cardGraphic->getAsString();

        $session->set('deck', $deck);

        return $this->render('card/test/draw.html.twig', [
            'drawnCard' => $card,
        ]);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "test_numbers")]
    public function testDrawCards(int $num, SessionInterface $session): Response
    {
        $deck = $session->get('deck');

        $numberOfCards = count($deck->getCards());
        if ($num > $numberOfCards) {
            throw new \Exception("Can not draw more than 52 cards!");
        }


        // $cardDraw = [];
        $cards = [];

        for ($i = 1; $i <= $num; $i++) {
            // $card = new CardGraphic();
            // // $card->draw();
            // $drawnCard = $deck->draw();
            // // $cardDraw[] = $card->getAsString();
            // $drawnCards[] = $drawnCard;
            $drawnCard = $deck->draw()[0];
            $cardGraphic = new CardGraphic();
            $cardGraphic->setSuit($drawnCard->getSuitCard());
            $cardGraphic->setValue($drawnCard->getValueCard());
            $cards[] = $cardGraphic->getAsString();
        }


        $session->set('deck', $deck);

        $data = [
            "num_cards" => count($cards),
            "cardDraw" => $cards,
        ];
        return $this->render('card/test/draw_many.html.twig', $data);
    }

    // #[Route('/card', name: 'card_init_get', methods: ['GET'])]
    // public function init(): Response
    // {
    //     return $this->render('card/init.html.twig');
    // }

    #[Route('/session', name: 'session_landing')]
    public function showSession(SessionInterface $session): Response
    {
        $sessionData = $session->all();

        return $this->render('session/show.html.twig', [
            'sessionData' => $sessionData,
        ]);
    }

    #[Route('/session/delete', name: 'session_delete')]
    public function deleteSession(SessionInterface $session): Response
    {
        $session->clear();

        $this->addFlash('success', 'Sessionen har raderats.');

        return $this->redirectToRoute('session_landing');
    }
}
