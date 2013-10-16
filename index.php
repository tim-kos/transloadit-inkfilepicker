<?php
require_once('helpers.php');

$results = array();
if (isset($_POST['transloadit'])) {
  $results = prepareTransloaditResults($_POST['transloadit']);
}
?>
<!doctype html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Transloadit meets InkFilepicker</title>
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>
  <div class="container">
    <h1>Transloadit meets InkFilepicker</h1>
    <p>Import images or videos from anywhere using the filepicker, and then see how Transloadit converts them.</p>
    <p>You can find the code for this <a href="https://github.com/tim-kos/transloadit-inkfilepicker">here</a>.</p>
    <hr />

    <?php if (!empty($results)) : ?>
      <h2>Form Fields</h2>
      <dl>
        <dt>Name:</dt><dd><?php echo $_POST['name'] ?></dd>
        <dt>Email:</dt><dd><?php echo $_POST['email_address'] ?></dd>
        <dt>Other:</dt><dd><?php echo $_POST['other_form_field'] ?></dd>
      </dl>
      <hr />

      <?php if (isset($results['resized'])) : ?>
        <h2>Resized Results</h2>
        <?php echo displayThumbnails($results['resized']) ?>
        <hr />
      <?php endif; ?>

      <?php if (isset($results['sepia'])) : ?>
        <h2>Sepia Results</h2>
        <?php echo displayThumbnails($results['sepia']) ?>
        <hr />
      <?php endif; ?>

      <?php if (isset($results['iphone_video_high'])) : ?>
        <h2>iPhone High-res Video</h2>
        <?php echo displayVideos($results['iphone_video_high']) ?>
        <hr />
      <?php endif; ?>

      <?php if (isset($results['iphone_video_low'])) : ?>
        <h2>iPhone Low-res Video</h2>
        <?php echo displayVideos($results['iphone_video_low']) ?>
        <hr />
      <?php endif; ?>

      <?php if (isset($results['video_thumbnails'])) : ?>
        <h2>Video Thumbnail Results</h2>
        <?php echo displayThumbnails($results['video_thumbnails']) ?>
        <hr />
      <?php endif; ?>
    <?php endif; ?>
    <div class="row">
      <div class="js-transloadit-upload col-md-4">
        <form role="form" action="index.php" enctype="multipart/form-data" method="POST">
          <div class="form-group">
            <label for="pick-files">Pick some files:</label>
            <button class="btn btn-primary js-pick-files" name="pick-files">Pick some files</button>
          </div>

          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" />
          </div>
          <div class="form-group">
            <label for="email_address">Email address:</label>
            <input type="text" name="email_address" id="email_address" class="form-control" />
          </div>
          <div class="form-group">
            <label for="other_form_field">Another form field:</label>
            <input type="text" name="other_form_field" id="other_form_field" class="form-control" />
          </div>

          <button type="submit" class="btn btn-default">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <script type="text/javascript" src="//api.filepicker.io/v1/filepicker.js"></script>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//assets.transloadit.com/js/jquery.transloadit2-v2-latest.js"></script>
  <script src="js/transloadit_uploader.js"></script>
</body>
</html>
