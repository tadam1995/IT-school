<?php

use Util\Util as Util;
use Database\Database as Database;

// Set environment
require_once('../../common/php/environment.php');

// Connect to database
$db = new Database();

// Set query
$query = "SELECT * FROM courses;";

// Execute query with argument
$result = $db->execute($query);

foreach($result as $i => $row) {
  
  // Set query
  $query = "SELECT *
            FROM `courses_subjects` 
            INNER JOIN `subjects`
            ON `subjects`.`subject_id` = `courses_subjects`.`subject_id`
            WHERE `course_id` = :id";

  // Execute query with argument
  $result[$i]['subjects'] = $db->execute($query, array("id" => $row['course_id']));

  foreach($result[$i]['subjects'] as $j => $row2) {

    // Set query
    $query = "SELECT *
              FROM  `teacher` 
              WHERE `teacher_id` = :id";

    // Execute query with argument
    $result[$i]['subjects'][$j]['teachers'] = 
        $db->execute($query, array("id" => $row2['teacher_id']));

    $a = 1;
  }
}

// Close connection
$db = null;

// Set response
Util::setResponse($result);