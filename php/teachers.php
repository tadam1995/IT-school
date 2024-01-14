<?php

use Util\Util as Util;
use Database\Database as Database;

// Set environment
require_once('../../common/php/environment.php');

// Connect to database
$db = new Database();

// Set query
$query = "SELECT CONCAT_WS(' ', `teacher`.`surname`, `teacher`.`first_name`) 
            AS  `full_name`,
                `teacher`.
                `email`,
                `img`,
                `content`,
                `teacher`.`phone`,
            (SELECT GROUP_CONCAT(`subjects`.`subject_name` SEPARATOR ', ')
              FROM `subjects`
              WHERE `subjects`.`teacher_id` = `teacher`.`teacher_id`)
                AS `subjects`
                FROM `teacher`
                ORDER BY `full_name`;";

// Execute query with argument
$result = $db->execute($query);

// Close connection
$db = null;

// Set response
Util::setResponse($result);