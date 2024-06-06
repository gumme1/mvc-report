<?php

namespace App\Controller\Card;

use App\Controller\Card\Card;

class Deck extends Card
{
    protected $cards;

    public function __construct()
    {
        $this->cards = [];
        $this->initializeDeck();
    }

    protected function initializeDeck(): void
    {
        foreach (['Hearts', 'Spades', 'Diamonds', 'Clubs'] as $suit) {
            for ($value = 1; $value <= 13; $value++) {
                $card = new Card();
                $card->suit = $suit;
                $card->value = $value;
                $this->cards[] = $card;
            }
        }
    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function draw(int $numCards = 1): array
    {
        $drawnCards = [];

        for ($i = 0; $i < $numCards; $i++) {
            if (!empty($this->cards)) {
                $drawnCards[] = array_shift($this->cards);
            }
        }

        return $drawnCards;
    }

    public function getCards(): array
    {
        return $this->cards;
    }
}
