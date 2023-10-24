<?php

// Set environment
require_once('../../../common/php/environment.php');

// Connect to database
$db = new Database();

// Set query
$query = "SELECT  CONCAT_WS(' ', `surname`, `first_name`) AS `name`,
                  `email`, 
                  `phone`,
                  ( SELECT GROUP_CONCAT(`subjects`.`name` SEPARATOR ', ')
                    FROM `subjects`
                    WHERE `subjects`.`teacher_id` = `teacher`.`id`
                  ) AS `subjects`
          FROM `teacher`
          ORDER BY `name`;";

// Execute query with argument
$result = $db->execute($query);

// Close connection
$db = null;

// Set response
Util::setResponse($result);