<?php
class Board{
    public $size;
    public $places;
    public $pid;
    public $strategy;
    public $winner_row = [];

    function __construct($size=15, $strategy=''){
        $this->size = $size;
        $this->places = array_fill(0, $size, array_fill(0, $size, 0));
        $this->pid = uniqid();
        $this->strategy = $strategy;
    }

    function write_file(){
        $path = "../data/" . $this->pid . ".txt";
        $file = fopen($path, "w") or die("Unable to open file!");
        fwrite($file, $this->toJson());
        fclose($file);
    }

    function toJson(){
        return json_encode($this);
    }

    function player_won($player_num){
        $this->check_if_horizontals_are_full($player_num);
        $this->check_if_verticals_are_full($player_num);
        $this->check_if_diagonals_are_full($player_num);
        return sizeof($this->winner_row) == 10;
    }

    function array_is_fill_with($array, $element){
        foreach($array as $num){
            if($num != $element){
                return false;
            }
        }
        return true;
    }

    //Gets 5 element row from dx and dy direction with x and y being the center
    function get_row($x, $y, $dx, $dy){
        $row = array();
        for($i = -2; $i < 3; $i++){
            array_push($row, $this->places[$x + $dx * $i][$y + $dy * $i]);
        }
        return $row;
    }

    function is_full(){
        foreach($this->places as $row){
            foreach($row as $item){
                if($item === 0){
                    return false;
                }
            }
        }
        return true;
    }

    static function fromJson($json){
        $obj = json_decode($json);
        $board = new Board();
        $board->size = $obj->size;
        $board->places = $obj->places;
        $board->pid = $obj->pid;
        $board->strategy = $obj->strategy;
        return $board;
    }

    public function place_is_empty($x, $y)
    {
        return $this->places[$x][$y] == 0;
    }

    static function get_board($pid){
        $path = "../data/" . $pid . ".txt";
        $file = fopen($path, "r") or die("Unable to open file!");
        $json = fread($file, filesize($path));
        fclose($file);

        return self::fromJson($json);
    }

    public function __toString(){
        $result = "";
        foreach($this->places as $row){
            foreach($row as $place){
                $result = $result . $place . ", ";
            }
            $result = $result . "<br>";
        }
        return $result;
    }

    private function check_if_diagonals_are_full($player_num)
    {
        for ($i = 2; $i < $this->size - 3; $i++) {
            for ($j = 2; $j < $this->size - 3; $j++) {
                $diagonal_row = $this->get_row($i, $j, 1, 1);
                if ($this->array_is_fill_with($diagonal_row, $player_num)) {
                    $this->winner_row = [];
                    array_push($this->winner_row,
                        $i - 2, $j - 2,
                        $i - 1, $j - 1,
                        $i, $j,
                        $i + 1, $j + 1,
                        $i + 2, $j + 2
                    );
                }

                $neg_diagonal_row = $this->get_row($i, $j, 1, -1);
                if ($this->array_is_fill_with($neg_diagonal_row, $player_num)) {
                    $this->winner_row = [];
                    array_push($this->winner_row,
                        $i + 2, $j - 2,
                        $i + 1, $j - 1,
                        $i, $j,
                        $i - 1, $j + 1,
                        $i - 2, $j + 2
                    );
                }
            }
        }
    }

    private function check_if_verticals_are_full($player_num)
    {
        for ($i = 0; $i < $this->size; $i++) {
            for ($j = 2; $j < $this->size - 3; $j++) {
                $vertical_row = $this->get_row($i, $j, 0, 1);
                if ($this->array_is_fill_with($vertical_row, $player_num)) {
                    $this->winner_row = [];
                    array_push($this->winner_row,
                        $i, $j - 2,
                        $i, $j - 1,
                        $i, $j,
                        $i, $j + 1,
                        $i, $j + 2
                    );
                }
            }
        }
    }

    private function check_if_horizontals_are_full($player_num)
    {
        for ($i = 2; $i < $this->size - 3; $i++) {
            for ($j = 0; $j < $this->size; $j++) {
                $horizontal_row = $this->get_row($i, $j, 1, 0);
                if ($this->array_is_fill_with($horizontal_row, $player_num)) {
                    $this->winner_row = [];
                    array_push($this->winner_row,
                        $i - 0, $j,
                        $i - 1, $j,
                        $i, $j,
                        $i + 1, $j,
                        $i + 2, $j
                    );
                }
            }
        }
    }
}

