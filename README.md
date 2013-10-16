transloadit-inkfilepicker
=========================

A sample integration between [Transloadit](https://transloadit.com) and [InkFilePicker](https://www.inkfilepicker.com/).

[Demo](https://transloadit.com/example_apps/inkfilepicker-integration/index.php)

## INSTALLATION

* Download, clone or fork this repository, and put the contents in a directory that is accessible by your webserver.
* Insert your InkFilePicker API key in /js/transloadit_uploader.js. Even though this seems to be not necessary at the moment, but will probably be fixed soon ...
* Insert your Transloadit Auth key and Auth secret in params.php.
* Adjust your desired Transloadit file conversion steps in params.php.
* Point your webserver to the index.php file. Pick some files, and submit the form.

This also works when you enable signature authentication on Transloadit for enhanced security.
