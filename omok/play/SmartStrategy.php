<?php
require_once('MoveStrategy.php');
require_once('RandomStrategy.php');

//based off previous implementations
class SmartStrategy extends MoveStrategy {
    public $picked_place = [];

    function pickPlace()
    {
        $this->picked_place = [];
        $this->check_if_rows_have_2_pieces();
        $this->check_if_rows_have_3_pieces();
        $this->check_if_rows_have_4_pieces();

        if(sizeof($this->picked_place) == 2){
            return $this->picked_place;
        }

        $random = new RandomStrategy($this->board);
        return $random->pickPlace();
    }

    function row_has_2_pieces($row){
        list($num_of_1s, $num_of_2s) = $this->count_1s_and_0s($row);
        return $num_of_2s == 0 && $num_of_1s > 0;
    }

    function row_has_3_pieces($row){
        list($num_of_1s, $num_of_2s) = $this->count_1s_and_0s($row);
        return $num_of_2s == 0 && $num_of_1s > 2;
    }

    function row_has_4_pieces($row){
        list($num_of_1s, $num_of_2s) = $this->count_1s_and_0s($row);
        return $num_of_2s == 0 && $num_of_1s > 3;
    }

    private function count_1s_and_0s($row)
    {
        $num_of_1s = 0;
        $num_of_2s = 0;
        foreach ($row as $num) {
            if ($num === 1) {
                $num_of_1s++;
            }

            if ($num === 2) {
                $num_of_2s++;
            }
        }
        return array($num_of_1s, $num_of_2s);
    }

    private function check_if_rows_have_2_pieces()
    {
        for ($i = 2; $i < 13; $i++) {
            for ($j = 2; $j < 13; $j++) {
                $this->check_if_horizontal_has_2_pieces($i, $j);
                $this->check_if_vertical_has_2_pieces($i, $j);
                $this->check_if_diagonal_has_2_pieces($i, $j);
                $this->check_if_neg_diagonal_has_2_pieces($i, $j);
            }
        }
    }

    private function check_if_horizontal_has_2_pieces($i, $j)
    {
        $horizontal_row = $this->get_row_of_size_3($i, $j, 1, 0);
        if ($this->row_has_2_pieces($horizontal_row)) {
            $this->place_piece_in_horizontal($horizontal_row, $i, $j);
        }
    }

    private function check_if_vertical_has_2_pieces($i, $j)
    {
        $vertical_row = $this->get_row_of_size_3($i, $j, 0, 1);
        if ($this->row_has_2_pieces($vertical_row)) {
            $this->place_piece_in_vertical($vertical_row, $i, $j);
        }
    }

    private function check_if_diagonal_has_2_pieces($i, $j)
    {
        $diagonal_row = $this->get_row_of_size_3($i, $j, 1, 1);
        if ($this->row_has_2_pieces($diagonal_row)) {
            $this->place_piece_in_diagonal($diagonal_row, $i, $j);
        }
    }

    private function check_if_neg_diagonal_has_2_pieces($i, $j)
    {
        $neg_diagonal_row = $this->get_row_of_size_3($i, $j, 1, -1);
        if ($this->row_has_2_pieces($neg_diagonal_row)) {
            $this->place_piece_in_neg_diagonal($neg_diagonal_row, $i, $j);
        }
    }

    private function check_if_neg_diagonal_has_3_pieces($i, $j)
    {
        $neg_diagonal_row = $this->board->get_row($i, $j, 1, -1);
        if ($this->row_has_3_pieces($neg_diagonal_row)) {
            $this->place_piece_in_neg_diagonal($neg_diagonal_row, $i, $j);
        }
    }

    private function check_if_diagonal_has_3_pieces($i, $j)
    {
        $diagonal_row = $this->board->get_row($i, $j, 1, 1);
        if ($this->row_has_3_pieces($diagonal_row)) {
            $this->place_piece_in_diagonal($diagonal_row, $i, $j);
        }
    }


    private function check_if_vertical_has_3_pieces($i, $j)
    {
        $vertical_row = $this->board->get_row($i, $j, 0, 1);
        if ($this->row_has_3_pieces($vertical_row)) {
            $this->place_piece_in_vertical($vertical_row, $i, $j);
        }
    }

    private function check_if_horizontal_has_3_pieces($i, $j)
    {
        $horizontal_row = $this->board->get_row($i, $j, 1, 0);
        if ($this->row_has_3_pieces($horizontal_row)) {
            $this->place_piece_in_horizontal($horizontal_row, $i, $j);
        }
    }

    private function check_if_rows_have_3_pieces()
    {
        for ($i = 2; $i < 13; $i++) {
            for ($j = 2; $j < 13; $j++) {
                $this->check_if_horizontal_has_3_pieces($i, $j);
                $this->check_if_vertical_has_3_pieces($i, $j);
                $this->check_if_diagonal_has_3_pieces($i, $j);
                $this->check_if_neg_diagonal_has_3_pieces($i, $j);
            }
        }
    }

    private function check_if_rows_have_4_pieces()
    {
        for ($i = 2; $i < 13; $i++) {
            for ($j = 2; $j < 13; $j++) {
                $this->check_if_horizontal_has_4_pieces($i, $j);
                $this->check_if_vertical_has_4_pieces($i, $j);
                $this->check_if_diagonal_has_4_pieces($i, $j);
                $this->check_if_neg_diagonal_has_4_pieces($i, $j);
            }
        }
    }

    private function check_if_horizontal_has_4_pieces($i, $j)
    {
        $horizontal_row = $this->board->get_row($i, $j, 1, 0);
        if ($this->row_has_4_pieces($horizontal_row)) {
            $this->place_piece_in_horizontal($horizontal_row, $i, $j);
        }
    }

    private function check_if_vertical_has_4_pieces($i, $j)
    {
        $vertical_row = $this->board->get_row($i, $j, 0, 1);
        if ($this->row_has_4_pieces($vertical_row)) {
            $this->place_piece_in_vertical($vertical_row, $i, $j);
        }
    }

    private function check_if_diagonal_has_4_pieces($i, $j)
    {
        $diagonal_row = $this->board->get_row($i, $j, 1, 1);
        if ($this->row_has_4_pieces($diagonal_row)) {
            $this->place_piece_in_diagonal($diagonal_row, $i, $j);
        }
    }

    private function check_if_neg_diagonal_has_4_pieces($i, $j)
    {
        $neg_diagonal_row = $this->board->get_row($i, $j, 1, -1);
        if ($this->row_has_4_pieces($neg_diagonal_row)) {
            $this->place_piece_in_neg_diagonal($neg_diagonal_row, $i, $j);
        }
    }

    private function place_piece_in_neg_diagonal(array $neg_diagonal_row, $i, $j)
    {
        for ($k = 0; $k < ceil(sizeof($neg_diagonal_row) / 2); $k++) {
            if ($neg_diagonal_row[floor(sizeof($neg_diagonal_row) / 2) + $k] === 0) {
                $this->picked_place = [$i + $k, $j - $k];
                return;
            }

            if ($neg_diagonal_row[floor(sizeof($neg_diagonal_row) / 2) - $k] === 0) {
                $this->picked_place = [$i - $k, $j + $k];
                return;
            }
        }
    }

    private function place_piece_in_diagonal(array $diagonal_row, $i, $j)
    {
        for ($k = 0; $k < ceil(sizeof($diagonal_row) / 2); $k++) {
            if ($diagonal_row[floor(sizeof($diagonal_row) / 2) + $k] === 0) {
                $this->picked_place = [$i + $k, $j + $k];
                return;
            }

            if ($diagonal_row[floor(sizeof($diagonal_row) / 2) - $k] === 0) {
                $this->picked_place = [$i - $k, $j - $k];
                return;
            }
        }
    }

    private function place_piece_in_vertical(array $vertical_row, $i, $j)
    {
        for ($k = 0; $k < ceil(sizeof($vertical_row) / 2); $k++) {
            if ($vertical_row[floor(sizeof($vertical_row) / 2) + $k] === 0) {
                $this->picked_place = [$i, $j + $k];
                return;
            }

            if ($vertical_row[floor(sizeof($vertical_row) / 2) - $k] === 0) {
                $this->picked_place = [$i, $j - $k];
                return;
            }
        }
    }

    private function place_piece_in_horizontal(array $horizontal_row, $i, $j)
    {
        for ($k = 0; $k < ceil(sizeof($horizontal_row) / 2); $k++) {
            if ($horizontal_row[floor(sizeof($horizontal_row) / 2) + $k] === 0) {
                $this->picked_place = [$i + $k, $j];
                return;
            }

            if ($horizontal_row[floor(sizeof($horizontal_row) / 2) - $k] === 0) {
                $this->picked_place = [$i - $k, $j];
                return;
            }
        }
    }



    private function get_row_of_size_3($x, $y, $dx, $dy)
    {
        $row = array();
        for($i = -1; $i < 2; $i++){
            array_push($row, $this->board->places[$x + $dx * $i][$y + $dy * $i]);
        }
        return $row;
    }
}