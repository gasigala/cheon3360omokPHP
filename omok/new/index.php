
<?php
require_once("../play/Board.php");

function create_and_write_to_file($path, $txt)
{
    $file = fopen("../data/" . $path . ".txt", "w") or die("Unable to open file!");
    fwrite($file, $txt);
    fclose($file);
}

define('STRATEGY', 'strategy');     // Constant
$strategies = ["Smart", "Random"];  // Supported Strategies

if (!array_key_exists(STRATEGY, $_GET)) {
    echo json_encode(array("response" => false , "reason" => "Strategy Not Specified"));
    exit;
}

$strategy = $_GET[STRATEGY];        // ?[QUERY STRING INPUT]
//echo $strategy;


if (in_array($strategy, $strategies)) {
    $board = new Board(15, $_GET[STRATEGY]);
    create_and_write_to_file($board->pid, $board->toJson());
    echo "{\"response\":true, \"pid\":\"" . $board->pid . "\"}";
} else {
    echo json_encode(array("response" => false , "reason" => "Unknown Strategy"));
}

