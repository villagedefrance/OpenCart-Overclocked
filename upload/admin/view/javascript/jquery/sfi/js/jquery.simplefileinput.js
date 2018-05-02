/**
 * SimpleFileInput 0.1 - A jQuery plugin to customise your file inputs
 * http://github.com/s43/Simple-file-input/
 * Requirements : jQuery 1.7+
 * 
 * :: Copyright (c) 2014 SAID ASSEMLAL
 *
 * Dual licensed under the MIT and GPL licenses.
 *
 * Overclocked Edition © 2018 | Villagedefrance
 */

(function($) {
    $.fn.simpleFileInput = function(options) {
        $('html').addClass('sfi-js');

        return this.each(function() {
            var defaults = {
                placeholder: 'Pick your file',
                wrapperClass: 'sfi-container',
                validClass: 'sfi-valid',
                errorClass: 'sfi-error',
                disabledClass: 'sfi-disabled',
                buttonText: 'Pick your file',
                allowedExts: false, // This has to be an array
                width: 300,
                onInit: function() {},
                onFileSelect: function() {},
                onError: function() {}
            };

            /* Init */
            var _options = $.extend(defaults, options),
                _input = $(this),
                _sfiWrapper = $('<div class="sfi-wrapper ' + _options.wrapperClass + (_input .is(':disabled') ? 'sfi-disabled' : '') + '"></div>'),
                _sfiFileName = $('<span class="sfi-filename empty">' + _options.placeholder + '</span>'),
                _sfiTrigger = $('<a href="#" class="sfi-trigger">' + _options.buttonText + '</a>');

            _options.onInit();

            /* Check if the input has been already stylised, if so then move forwards. */
            if ($(this).next('.sfi-wrapper').length) {
                return;
            }

            /* Generate the DOM Elements */
            _sfiWrapper.insertAfter(_input);
            _sfiWrapper.attr("tabindex", _input.attr("tabindex") || "0");

            if (_options.width != false) {
                _sfiWrapper.css('width', _options.width + 'px');
			}

            _sfiFileName.appendTo(_sfiWrapper);
            _sfiTrigger.appendTo(_sfiWrapper);

            /* Hide the old input, it still can be used in the background */
            _input.hide();

            /* If the input is disabled, don't apply the events, and just move forward. */
            if (_input.is(':disabled')) {
                _sfiWrapper.addClass('.sfi-disabled');
                return;
            }

            /* Events &/ Triggers */
            _sfiTrigger.unbind('click').bind('click', function(e) {
                _triggerInput(e);
            });

            _sfiFileName.unbind('click').bind('click', function(e) {
                _triggerInput(e);
            });

            _input.bind('change', function(e) {
                _val = $(this).val();

                if (_checkAllowedExtensions(_val) == true) {
                    _sfiFileName.text(_getFileName(_val));
                    _options.onFileSelect();
                    _sfiWrapper.removeClass(_options.errorClass);
                    _sfiWrapper.addClass(_options.validClass);
                } else {
                    _options.onError();
                    _input.val('');
                    _sfiWrapper.removeClass(_options.validClass);
                    _sfiWrapper.addClass(_options.errorClass);
                }
            });

            /* _getFileName() : Get the selected file's name */
            function _getFileName(_fakePath) {
                var _index = ((_fakePath.indexOf('\\') >= 0) ? _fakePath.lastIndexOf('\\') : _fakePath.lastIndexOf('/'));
                var _filename = _fakePath.substring(_index);

                if (_filename.indexOf('\\') === 0 || _filename.indexOf('/') === 0) {
                    _filename = _filename.substring(1);
                }

                return _filename;
            }

            /* _triggerInput() : Trigger the click event on the hidden input */
            function _triggerInput(_e) {
                _e.preventDefault();
                _input.trigger('click');
            }

            /* _checkAllowedExtensions() : Check for the allowed extensions if there is, and return a valid or non-valid response. */
            function _checkAllowedExtensions(_filename) {
                var _filename = ( _filename ) ? _filename : '';
                var _allowed = _options.allowedExts, _ext = _filename.split('.').pop();

                if (_ext == '' || _allowed == false) {
                    return true;
                }

                if ($.inArray(_ext, _allowed) !== -1) {
                    return true;
                } else {
                    return false;
                }
            }
        });
    };

})(jQuery);
