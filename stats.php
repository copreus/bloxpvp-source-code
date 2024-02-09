<?php

session_start();
if (get_included_files()[0] != __FILE__) {return;}

include_once "main.php";
include_once "session_handler.php";

if (true) {

  $giveaways_count = 0;
  $games_count = 0;
  $total_value = 0;
  $biggest_game = 0;

  $result = $conn->query('SELECT game_id FROM games WHERE 1 ORDER BY game_id DESC LIMIT 0, 1');
  $row = $result->fetch_row(); $games_count = intval($row[0]);

  $result = $conn->query('SELECT giveaway_id FROM giveaways WHERE 1 ORDER BY giveaway_id DESC LIMIT 0, 1');
  $row = $result->fetch_row(); $giveaways_count = intval($row[0]);

  $result = $conn->query('SELECT SUM(starter_value), SUM(player_value) FROM `games` WHERE 1');
  $row = $result->fetch_row(); $total_value = intval($row[0]) + intval($row[1]);

  $result = $conn->query('SELECT starter_value, player_value FROM `games` WHERE 1 ORDER BY starter_value DESC LIMIT 0, 1');
  $row = $result->fetch_row(); $biggest_game = intval($row[0]) + intval($row[1]);

  exit(json_encode([
    'result' => 'OK', 'data' => [
      'giveaways' => [
        'count' => $giveaways_count
      ],
      'games' => [
        'count' => $games_count,
        'value' => $total_value,
        'biggest' => $biggest_game
      ]
    ]
  ]));

}