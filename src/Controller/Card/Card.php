<?php

namespace App\Controller\Card;

class Card
{
    protected $suit;
    protected $value;

    public function __construct()
    {
        $this->suit = null;
        $this->value = null;
    }

    private function getRandomSuit(): string
    {
        $suits = ['Hearts', 'Spades', 'Diamonds', 'Clubs'];
        $randomIndex = array_rand($suits);
        return $suits[$randomIndex];
    }

    // public function draw(): int
    // {
    //     $this->value = random_int(1,21);
    //     return  $this->value;
    // }

    public function draw(): array
    {
        $this->value = random_int(1, 13);
        $this->suit = $this->getRandomSuit();
        return ['suit' => $this->suit, 'value' => $this->value];
    }

    // public function draw(): self
    // {
    //     $this->value = random_int(1, 13);
    //     $this->suit = $this->getRandomSuit();
    //     return $this;
    // }

    public function getValueCard(): int
    {
        return $this->value;
    }

    public function getSuitCard(): string
    {
        return $this->suit;
    }

    // public function getAsStringCard(): string
    // {
    //     return "[{$this->value}]";
    // }

    public function getAsStringCard(): string
    {
        return "{$this->value} of {$this->suit}";
    }
}


// class Deck
// {
//     private $cards = [];

//     public function __construct()
//     {
//         // Initialize deck with cards
//     }

//     public function shuffle()
//     {
//         // Shuffle the deck
//     }

//     public function draw()
//     {
//         // Draw a card from the deck
//     }

//     // Other methods for deck manipulation
// }
