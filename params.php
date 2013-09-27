<?php
require_once('helpers.php');

$authKey    = 'YOUR-TRANSLOADIT-AUTH-KEY';
$authSecret = 'YOUR-TRANSLOADIT-AUTH-SECRET';

function getTransloaditParamsAndSignature() {
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

  $signature = calcSignature($authSecret, $params);

  return compact('signature', 'params');
}
?>
