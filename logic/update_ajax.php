#!/usr/local/bin/php -d display_errors=STDOUT
<?php
$database = "dbfight.db";
try {
  $db = new SQLite3($database);
} catch (Exception $exception) {
  echo '<p>There was an error connecting to the database!</p>';

  if ($db) {
      echo $exception->getMessage();
    }
}
$table = "fightdata";

$question_arr[0] = 0;
$question_arr[1] = 0;
$question_arr[2] = 0;
$question_arr[3] = 0;

$sql = "SELECT * FROM $table";
$result = $db->query($sql);

while ($record = $result->fetchArray()) {

  if ($record['id'] == $_GET['id']) {
    if ($record['vote'] == "opp_1") {
        $question_arr[0]++;
      } else if ($record['vote'] == "opp_2") {
        $question_arr[1]++;
      } else if ($record['vote'] == "opp_3") {
      $question_arr[2]++;
    } else if ($record['vote'] == "opp_4") {
      $question_arr[3]++;
    }
  }
}
foreach ($question_arr as $key => $val) {
    print "$val" . ";";
  }
?> 