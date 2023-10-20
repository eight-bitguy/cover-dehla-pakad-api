<?php

namespace App\Services;

use App\Card;
use App\Game;
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
    public function getAllTrumpCards(Game $game, ?string $trump)
    {
        $cards = $game->stake;

        $isTrumpOpenedInCurrentIteration = (
            $trump 
            && $trump[Card::DECK_INDEX] != $game->stake[0][Card::DECK_INDEX]
            && Game::where('room_id', $game->room_id)
                ->where('id', '<', $game->id - 1)
                ->where('next_chance', null)
                ->orderBy('id', 'desc')
                ->first()->trump_decided_by == null);
        
        if ($isTrumpOpenedInCurrentIteration) {
            $lastPlayedBy = $game->played_by;
            
            $endingIndex = array_search($lastPlayedBy, Room::ALL_POSITIONS);
            $startingIndex = ($endingIndex + 1 ) %4;
            $trumpOpendedAtIndex = 0;

            while(true) {
                if(Room::ALL_POSITIONS[$startingIndex] == $game->trump_decided_by) {
                    break;
                }
                $startingIndex = ($startingIndex + 1 ) %4;
                $trumpOpendedAtIndex = $trumpOpendedAtIndex + 1;
            }
            
            $cards = array_slice($cards, $trumpOpendedAtIndex, 4 - $trumpOpendedAtIndex);
        }
        
        return array_values(array_filter($cards, function ($card) use ($trump) {
            return $card[Card::DECK_INDEX] === $trump[Card::DECK_INDEX];
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
     * @param Game $game
     * @param string $trump
     * @return string
     */
    public function getHighestCardFromDifferentDecks(Game $game, ?string $trump): string
    {
        
        $allTrumpCards = $this->getAllTrumpCards($game, $trump);
        if (count($allTrumpCards)) {
            return $this->getHighestCardFromSameDeck($allTrumpCards);
        }

        $cards = $game->stake;
        $suitIteration = $cards[0][Card::DECK_INDEX];
        $deckWithChance = [];
        foreach ($cards as $card) {
            if ($card[Card::DECK_INDEX] == $suitIteration) {
                array_push($deckWithChance, $card);
            }
        }

        return $this->getHighestCardFromSameDeck($deckWithChance);
    }



}
