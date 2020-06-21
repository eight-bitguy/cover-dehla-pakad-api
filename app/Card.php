<?php

namespace App;

class Card extends Model
{
    const DECK_SPADES = 'S';
    const DECK_HEART = 'H';
    const DECK_DIAMOND = 'D';
    const DECK_CLUBS = 'C';

    const ALL_DECK = [
        self::DECK_SPADES,
        self::DECK_HEART,
        self::DECK_DIAMOND,
        self::DECK_CLUBS,
    ];

    const RANK_ACE  = 'A';
    const RANK_TWO = '2';
    const RANK_THREE = '3';
    const RANK_FOUR = '4';
    const RANK_FIVE = '5';
    const RANK_SIX = '6';
    const RANK_SEVEN = '7';
    const RANK_EIGHT = '8';
    const RANK_NINE = '9';
    const RANK_TEN = 'T';
    const RANK_JACK = 'J';
    const RANK_QUEEN = 'Q';
    const RANK_KING = 'K';

    const ALL_RANKS = [
        self::RANK_TWO,
        self::RANK_THREE,
        self::RANK_FOUR,
        self::RANK_FIVE,
        self::RANK_SIX,
        self::RANK_SEVEN,
        self::RANK_EIGHT,
        self::RANK_NINE,
        self::RANK_TEN,
        self::RANK_JACK,
        self::RANK_QUEEN,
        self::RANK_KING,
        self::RANK_ACE
    ];

    const TOTAL_CARDS = 52;

    const RANK_INDEX = 0;
    const DECK_INDEX = 1;

    /**
     * @return array
     */
    static function getAllCards(): array
    {
        $allCards = [];
        foreach (self::ALL_DECK as $deck)
        {
            foreach (self::ALL_RANKS as $rank)
            {
                $card = '  ';
                $card[self::RANK_INDEX] = $rank;
                $card[self::DECK_INDEX] = $deck;
                $allCards[] = $card;
            }
        }

        return $allCards;
    }

    /**
     * @param string $card
     * @return bool
     */
    static function isValid(string $card)
    {
        $isRankValid = in_array($card[self::RANK_INDEX], self::ALL_RANKS);
        $isDeckValid = in_array($card[self::DECK_INDEX], self::ALL_DECK);

        return $isRankValid && $isDeckValid;
    }

    /**
     * @param string $rank
     * @return mixed
     */
    static function getRankInNumber(string $rank)
    {
        $rankMap = array_combine(self::ALL_RANKS, array_keys(self::ALL_RANKS));
        return $rankMap[$rank] ? $rankMap[$rank] : $rankMap[+$rank];
    }

}
