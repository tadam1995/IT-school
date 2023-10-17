<?php
$skeleton = '../media/image/carousel/*.{jpg,jpeg,png,gif,webp}';
$files    = glob($skeleton, GLOB_BRACE);
$result   = array();
foreach($files as $file) {
  $result[] = basename($file);
}
shuffle($result);
echo json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);