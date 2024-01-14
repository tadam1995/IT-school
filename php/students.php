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
$query = "INSERT INTO `students`
            (`course_id`, `beg`, `user_id`) 
            VALUES (:courseId, :beg, :userId)";

// Execute query with argument
$result = $db->execute($query, $args);

// Close connection
$db = null;

// Set response
Util::setResponse($result);