<?php
require_once('SmartStrategy.php');
require_once('RandomStrategy.php');

class Game{
    public $board;
    public $strategies;

    function __construct($board){
        $this->board = $board;
        $this->strategies = array(
            'Smart' => 'SmartStrategy',
            'Random' => 'RandomStrategy'
        );
    }

    function make_client_move($x, $y){
        $this->board->places[$x][$y] = 1;
        $this->board->write_file();
    }

    function get_svr_move(){
        $strategy = new $this->strategies[$this->board->strategy]($this->board);
        return $strategy->pickPlace();
    }

    //Gets the winner row of player 1 if he won
    function get_player1_returning_row(){
        if(!$this->board->player_won(1)){
            return [];
        }

        if(count($this->board->winner_row) === 0){
            return [];
        }

        return $this->board->winner_row;
    }

    //Gets the winner row of player to if he won
    function get_player2_returning_row(){
        if(!$this->board->player_won(2)){
            return [];
        }

        if(count($this->board->winner_row) === 0){
            return [];
        }

        return $this->board->winner_row;
    }
}

