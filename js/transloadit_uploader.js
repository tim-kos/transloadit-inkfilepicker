(function ($) {
  function TransloaditUploader() {
    this.filepickerApiKey   = 'INKFILEPICKER-API-KEY';
  }

  TransloaditUploader.prototype.init = function($container) {
    this.$form                 = $container.find('form');
    this.$pickBtn              = $container.find('.js-pick-files');
    this.transloaditImportUrls = [];
    this.wasSubmitted          = false;

    filepicker.setKey(this.filepickerApiKey);
    this._bindFilePicking();
    this._bindFormSubmit();

    return this;
  };

  TransloaditUploader.prototype._bindFilePicking = function() {
    var self = this;

    this.$pickBtn.on('click', function(e) {
      e.preventDefault();

      filepicker.pickMultiple(function(inkBlobs) {
        for (var i = 0; i < inkBlobs.length; i++) {
          self.transloaditImportUrls.push(inkBlobs[i].url);
        }
      });
    });
  };

  TransloaditUploader.prototype.reset = function() {
    this.$form.find('input[type=text]').val('');
    this.wasSubmitted = false;
  };

  TransloaditUploader.prototype._bindFormSubmit = function() {
    var self = this;

    this.$form.on('submit', function(e) {
      if (self.transloaditImportUrls.length === 0) {
        e.preventDefault();
        self._showError('Please first pick some files!');
      } else if (!self.wasSubmitted) {
        e.preventDefault();

        self._bindTransloadit(function() {
          self.$form.trigger('submit.transloadit');
          self.wasSubmitted = true;
        });
      }
    });
  };

  TransloaditUploader.prototype._bindTransloadit = function(cb) {
    var self = this;

    this._fetchParamsAndSignature(function(params, signature) {
      self.$form.transloadit({
        wait: true,
        fields: true,
        params: params,
        signature: signature,
        onError: function(assembly) {
          var err = 'There was a problem processing the files.';
          self._showError(err);
        }
      });

      cb();
    });
  };

  TransloaditUploader.prototype._fetchParamsAndSignature = function(cb) {
    var data = {
      url: this.transloaditImportUrls
    };
    $.post('params.php', data, function(response) {
      cb(response.params, response.signature);
    });
  };

  TransloaditUploader.prototype._showError = function(err) {
    alert(err);
  };

  $.fn.transloaditUpload = function() {
    var obj = (new TransloaditUploader()).init(this);
    return this.data('transloaditUploader', obj);
  };

  $(function() {
    $('.js-transloadit-upload').each(function() {
      $(this).transloaditUpload();
    });
  });
})(jQuery);
