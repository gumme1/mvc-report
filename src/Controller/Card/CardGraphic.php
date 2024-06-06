<?php

namespace App\Controller\Card;

use App\Controller\Card\Card;

class CardGraphic extends Card
{
    private $suitsRepresentation = [
        'Hearts' => '♥️',
        'Spades' => '♠️',
        'Diamonds' => '♦️',
        'Clubs' => '♣️',
    ];

    private $valuesRepresentation = [
        1 => 'A',
        2 => '2',
        3 => '3',
        4 => '4',
        5 => '5',
        6 => '6',
        7 => '7',
        8 => '8',
        9 => '9',
        10 => '10',
        11 => 'J',
        12 => 'Q',
        13 => 'K',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function setSuit(string $suit): void
    {
        $this->suit = $suit;
    }

    public function getSuitCard(): string
    {
        return $this->suit;
    }

    public function getValueCard(): int
    {
        return $this->value;
    }
    public function getAsString(): string
    {
        $suit = $this->suitsRepresentation[$this->suit];
        $value = $this->valuesRepresentation[$this->value];
        return $value . $suit;
    }
}
