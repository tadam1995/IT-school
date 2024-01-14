<?php

use Util\Util as Util;
use Database\Database as Database;

// Set environment
require_once('../../common/php/environment.php');

// Connect to database
$db = new Database();

// Set query
$query = "  SELECT      courses.course_name,
                        subjects.subject_name,
                        subjects.description,
                        CONCAT_WS(' ', teacher.surname, teacher.first_name) AS teacher_name
                        FROM courses
                        JOIN courses_subjects 
                        ON courses.course_id = courses_subjects.course_id
                        JOIN subjects 
                        ON courses_subjects.subject_id = subjects.subject_id
                        JOIN teacher 
                        ON subjects.teacher_id = teacher.teacher_id;
";

// Execute query with argument
$result = $db->execute($query);

// Close connection
$db = null;

// Set response
Util::setResponse($result);

?>


