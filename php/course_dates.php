<?php

use Util\Util as Util;
use Database\Database as Database;

// Set environment
require_once('../../common/php/environment.php');

// Get arguments
$args = Util::getArgs();

// Connect to database
$db = new Database();

// Set query
$query = "SELECT `beg` 
            FROM `courses_data`
           WHERE `course_id` = :course_id
        ORDER BY `beg`;";

// Execute query with argument
$result = $db->execute($query, array("course_id" => $args['id']));

if (!is_null($result)) {

  $denes = array();
  foreach($result as $item) {
    array_push($denes, $item['beg']);
  }
  $result = $denes;
}

// Set response
Util::setResponse($result);