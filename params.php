<?php
$authKey    = 'YOUR-TRANSLOADIT-AUTH-KEY';
$authSecret = 'YOUR-TRANSLOADIT-AUTH-SECRET';

$params = array(
  'auth' => array(
    'expires' => gmdate('Y/m/d H:i:s+00:00', strtotime('+1 hour')),
    'key'     => $authKey,
    'referer' => $_SERVER['HTTP_HOST']
  ),
  'steps' => array()
);

$transloaditImportUrls = isset($_POST['url']) ? $_POST['url'] : array();

$params['steps'] = array(
    "imported" => array(
    "robot" => "/http/import",
    "url" => $transloaditImportUrls
  ),
  "resized" => array(
    "robot"           => "/image/resize",
    "use"             => "imported",
    "width"           => 125,
    "height"          => 125,
    "resize_strategy" => "pad",
    "background"      => "#000000"
  ),
  "sepia" => array(
    "robot"           => "/image/resize",
    "use"             => "imported",
    "width"           => 125,
    "height"          => 125,
    "resize_strategy" => "pad",
    "background"      => "#000000",
    "sepia"           => 70
  ),
  "iphone_video_high" => array(
    "robot"  => "/video/encode",
    "use"    => "imported",
    "preset" => "iphone-high"
  ),
  "iphone_video_low" => array(
    "robot"  => "/video/encode",
    "use"    => "imported",
    "preset" => "iphone-low"
  ),
  "video_thumbnails" => array(
    "robot"  => "/video/thumbs",
    "use"    => "imported",
    "width"  => 125,
    "height" => 125
  )
);
// json_encode escapes slashes by default, which would result in a wrong signature
// If you run PHP 5.4, you could also use the JSON_UNESCAPED_SLASHES bitmask in
// the second argument to json_encode
$encodedParams = str_replace('\/','/', json_encode($params));
$signature     = hash_hmac('sha1', $encodedParams, $authSecret);

header('Content-type: application/json');
echo json_encode(compact('signature', 'params'));
?>
