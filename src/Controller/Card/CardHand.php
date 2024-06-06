<?php

namespace App\Controller\Card;

use App\Controller\Card\Card;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function draw(): void
    {
        foreach ($this->hand as $card) {
            $card->draw();
        }
    }

    public function getNumberCards(): int
    {
        return count($this->hand);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getValueCard();
            $suits[] = $card->getSuitCard();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsStringCard();
        }
        return $values;
    }
}
