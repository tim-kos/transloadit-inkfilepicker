(function ($) {
  function TransloaditUploader() {
    this.transloaditAuthKey = 'TRANSLOADIT-AUTH-KEY';
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

        self._bindTransloadit();
        self.$form.trigger('submit.transloadit');
        self.wasSubmitted = true;
      }
    });
  };

  TransloaditUploader.prototype._bindTransloadit = function() {
    var self = this;
    this.$form.transloadit({
      wait: true,
      fields: true,
      params: {
        auth: {
          key: this.transloaditAuthKey
        },
        steps: {
          imported: {
            robot: "/http/import",
            url: this.transloaditImportUrls
          },
          resized: {
            robot: "/image/resize",
            use: "imported",
            width: 125,
            height: 125,
            resize_strategy: "pad",
            background: "#000000"
          },
          sepia: {
            robot: "/image/resize",
            use: "imported",
            width: 125,
            height: 125,
            resize_strategy: "pad",
            background: "#000000",
            sepia: 70
          },
          iphone_video_high: {
            robot: "/video/encode",
            use: "imported",
            preset: "iphone-high"
          },
          iphone_video_low: {
            robot: "/video/encode",
            use: "imported",
            preset: "iphone-low"
          },
          video_thumbnails: {
            robot: "/video/thumbs",
            use: "imported",
            width: 125,
            height: 125
          }
        }
      },
      onError: function(assembly) {
        var err = 'There was a problem processing the files.';
        self._showError(err);
      }
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
