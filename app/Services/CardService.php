<?php

namespace App\Services;

use App\Card;
use App\Room;

class CardService extends Service
{

    /**
     * @return array|false
     */
    public function getShuffledCards()
    {
        $allCards = Card::getAllCards();
        $cardsToPlayers = $this->getPlayersArray();
        $array = [
            'a1' => [],
            'a2' => [],
            'b1' => [],
            'b2' => [],
        ];

        foreach ($cardsToPlayers as $index => $position) {
            $positionArray = $array[$position];
            array_push($positionArray, $allCards[$index]);
            $array[$position] = $positionArray;
        }
        return $array;
    }

    /**
     * @return array
     */
    public function getPlayersArray(): array
    {
        $allPositionArray = array_merge(
            array_fill(0, 13, Room::POSITION_A1),
            array_fill(0, 13, Room::POSITION_A2),
            array_fill(0, 13, Room::POSITION_B1),
            array_fill(0, 13, Room::POSITION_B2)
        );

        shuffle($allPositionArray);
        return $allPositionArray;
    }

    /**
     * @param array $cards
     * @param string $trump
     * @return array
     */
    public function getAllTrumpCards(array $cards, ?string $trump)
    {
        return array_values(array_filter($cards, function ($card) use ($trump) {
            return $card[Card::DECK_INDEX] === $trump;
        }));
    }

    /**
     * @param string $rank1
     * @param string $rank2
     * @return bool
     */
    public function compareRank(string $rank1, string $rank2)
    {
        return Card::getRankInNumber($rank1) > Card::getRankInNumber($rank2);
    }


    /**
     * @param array $cards
     * @return string
     */
    public function getHighestCardFromSameDeck(array $cards)
    {
        $maxRank = Card::RANK_TWO;
        $deck = $cards[0][Card::DECK_INDEX];

        array_walk($cards, function ($card) use (&$maxRank) {
            $currentRank = $card[Card::RANK_INDEX];
            $isCurrentRankGreater = $this->compareRank($currentRank, $maxRank);

            if ($isCurrentRankGreater) {
                $maxRank = $currentRank;
            }
        });

        $card = '  ';
        $card[Card::RANK_INDEX] = $maxRank;
        $card[Card::DECK_INDEX] = $deck;
        return $card;
    }

    /**
     * @param array $cards
     * @param string $deck
     * @return array
     */
    public function getCardsOfDeck(array $cards, string $deck)
    {
        return array_filter($cards, function($card) use ($deck) {
            return $card[Card::DECK_INDEX] === $deck;
        });
    }

    /**
     * @param array $cards
     * @return bool
     */
    public function getFirstPotentialTrumpCard(array $cards)
    {
        $potentialTrump = false;
        $firstCardDeck = $cards[0][Card::DECK_INDEX];

        array_walk($cards, function ($card) use ($firstCardDeck, &$potentialTrump) {
            if ($firstCardDeck !== $card[Card::DECK_INDEX] && !$potentialTrump) {
                $potentialTrump = $card;
            }
        });

        return $potentialTrump;
    }

    /**
     * @param array $cards
     * @param string $trump
     * @param int $firstChanceIndex
     * @return string
     */
    public function getHighestCardFromDifferentDecks(array $cards, ?string $trump, int $firstChanceIndex = 0): string
    {

        $allTrumpCards = $this->getAllTrumpCards($cards, $trump);

        if (count($allTrumpCards)) {
            return $this->getHighestCardFromSameDeck($allTrumpCards);
        }

        $chanceOfDeck = $cards[$firstChanceIndex][Card::DECK_INDEX];
        $cardsToConsider = $this->getCardsOfDeck($cards, $chanceOfDeck);
        return $this->getHighestCardFromSameDeck($cardsToConsider);
    }



}
