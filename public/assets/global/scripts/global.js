"use strict";

if (typeof Object.create !== 'function') {
    Object.create = function (obj) {
        function F() {
        }

        F.prototype = obj;
        return new F();
    }
}

window.nbUtility = (function (document, $) {
        var self = {}, $elementClicked = null, modalBoxSelector = '#mobile-valid-modal';

        self.checkAsInteger = function (id) {
            var regularRex = /[0-9]+/;
            return regularRex.test(id);
        };

        self.isObject = function (value) {
            return value != null && typeof value === 'object';
        };

        self.checkEmail = function (email) {
            var reg = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/;
            return reg.test(email);
        };

        self.notEmpty = function (data) {
            return !(this.isUndefined(data)) && $.trim(data) != '';
        };

        self.trim = function (str) {
            return $.trim(str);
        };

        self.isDomExist = function (dom) {
            return dom.length;
        };

        self.isUndefined = function (str) {
            return typeof str === 'undefined';
        };

        self.convertThumb = function (src, path, defaultPath) {
            var imgInfo;
            if (typeof src == 'string') {
                imgInfo = src.split('.');
                return path + imgInfo[0] + '_thumb.' + imgInfo[1];
            } else if (this.isObject(src)) {
                if (src['image_url'] != '') {
                    path = path.replace('user_id', src.user_id);
                    imgInfo = src['image_url'].split('.');
                    return path + imgInfo[0] + '_thumb.' + imgInfo[1];
                } else {
                    if (src['gender'] == 1) {
                        return '/img/profile_image/male_default_profile.png'
                    } else {
                        return '/img/profile_image/female_default_profile.png'
                    }
                }
            }
            else {
                return defaultPath;
            }
        };

        self.convertProfilePicThumb = function (src, path, suffix) {
            if (this.isObject(src)) {
                src = $.extend({}, {image_source: ''}, src);
                if (src.image_source != '') {
                    path = path.replace('user_id', src.user_id);
                    var imgInfo = src.image_source.split('.');
                    return path + imgInfo[0] + '_' + suffix + '.' + imgInfo[1];
                } else {
                    if (src['gender'] == 1) {
                        return '/img/profile_image/male_default_' + suffix + '.png'
                    } else {
                        return '/img/profile_image/male_default_' + suffix + '.png'
                    }
                }
            } else {
                return '/img/profile_image/male_default_profile.png'
            }
        };

        self.convertOriginal = function (src, path, defaultPath) {
            if (src) {
                return path.replace('thumb', 'original') + src;
            } else {
                return defaultPath;
            }
        };


        self.count = function (array) {
            return Object.keys(array).length;
        };

        self.isFunction = function (value) {
            return typeof value === 'function';
        };

        self.getBooleanAsBinary = function (value) {
            return this.notEmpty(value) && !isNaN(value = parseInt(value)) ? value : 0;
        };

        self.getIntegerAfterReplacement = function (value, replacedBy) {
            return this.getBooleanAsBinary(value.replace(replacedBy, ''));
        };

        self.getUserFullName = function (obj) {
            obj = $.extend({}, {first_name: '', middle_name: '', last_name: '', nickname: ''}, obj);
            var name = '', nickname = obj.nickname;
            if (nbUtility.isUndefined(nickname) || nickname == null || nickname == '') {
                name = [obj.first_name, obj.middle_name, obj.last_name].join(' ');
            } else {
                name = obj.nickname;
            }
            return name;
        };

        self.redirect = function (url) {
            url = this.isUndefined(url) ? window.location.href : this.trim(url);
            window.location = this.trim(url);
        };

        self.convertReadableTime = function (totalSec) {
            var hours = parseInt(totalSec / 3600);
            var seconds_left = (totalSec % 3600);
            var minutes = parseInt(seconds_left / 60);
            var seconds = parseInt(seconds_left % 60);
            return (hours + 'h ' + minutes + 'm ' + seconds + 's');
        };

        self.getTimeForDate = function (time) {
            var from = new Date().getTime() / 1000;
            time = from - time;

            var secondsInPeriod = {
                'Years': 946080000,
                'Months': 2592000,
                'Days': 86400,
                'Hours': 3600,
                'Minutes': 60,
                'Seconds': 1
            };

            var count = 0, name = '';
            $.each(secondsInPeriod, function (period, second) {
                name = period;
                return ((count = Math.floor(time / second)) == 0);
            });

            return count + ' ' + name + '  ' + 'Ago';
        };

        self.convertNumFromBnToEn = function (bnNum) {
            bnNum = this.trim(bnNum).toString();
            var dst = {'০': 0, '১': 1, '২': 2, '৩': 3, '৪': 4, '৫': 5, '৬': 6, '৭': 7, '৮': 8, '৯': 9},
                enNum = '', i;
            for (i = 0; i < bnNum.length; i++) {
                enNum += dst[bnNum[i]];
            }

            return parseInt(enNum);
        };

        self.convertNumFromEnToBn = function (enNum) {
            enNum = this.trim(enNum).toString();
            var bengaliDigits = ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'], bnNum = '', i;
            for (i = 0; i < enNum.length; i++) {
                bnNum += bengaliDigits[parseInt(enNum[i])];
            }
            return bnNum;
        };

        self.convertFloatNumFromBnToEn = function (bnNum) {
            bnNum = this.trim(bnNum).toString();
            var dst = {'০': 0, '১': 1, '২': 2, '৩': 3, '৪': 4, '৫': 5, '৬': 6, '৭': 7, '৮': 8, '৯': 9, '.': '.'},
                enNum = '', i;
            for (i = 0; i < bnNum.length; i++) {
                enNum += (bnNum[i] in dst ? dst[bnNum[i]] : bnNum[i]);
            }
            return this.notEmpty(enNum) && !isNaN(enNum = parseFloat(enNum)) ? enNum : 0;
        };

        self.convertFloatNumFromEnToBn = function (enNum) {
            enNum = this.trim(enNum).toString();
            var bengaliDigits = {
                    0: '০',
                    1: '১',
                    2: '২',
                    3: '৩',
                    4: '৪',
                    5: '৫',
                    6: '৬',
                    7: '৭',
                    8: '৮',
                    9: '৯',
                    '.': '.'
                },
                bnNum = '', i;
            for (i = 0; i < enNum.length; i++) {
                bnNum += (enNum[i] in bengaliDigits ? bengaliDigits[enNum[i]] : enNum[i]);
            }
            return bnNum;
        };

        self.blinkElement = function (element) {
            element.animate({opacity: 0}, 600, 'linear', function () {
                $(this).animate({opacity: 1}, 200);
            });
        };

        self.isHide = function (dom) {
            return (dom.css('display') == 'none');
        };

        self.initializeFlashMessageActivity = function () {
            $('div.alert-message').delay(2500).slideUp();

            $('div.alert-message a.close').on('click', function () {
                $(this).parent().slideUp(function () {
                    $(this).remove();
                });
                return false;
            });
        };

        self.showFlashMessage = function (message, status) {
            switch (status) {
                case 'success':
                    alert(message);
                    break;

                case 'error':
                    alert(message);
                    break;
            }
        };


        self.isUserLoggedIn = function () {
            var isUserLoggedIn = $('#isUserLoggedIn').val();
            isUserLoggedIn = this.notEmpty(isUserLoggedIn) && !isNaN(isUserLoggedIn = parseInt(isUserLoggedIn)) ? isUserLoggedIn : 0;
            return !!isUserLoggedIn;
        };

        self.generateUid = function (separator) {
            var delimiter = separator || '-';

            /** @return {string} */
            function S4() {
                return (((1 + Math.random()) * 0x10000) | 0).toString(16).substring(1);
            }

            return (S4() + S4() + delimiter + S4() + delimiter + S4() + delimiter + S4() + delimiter + S4() + S4() + S4());
        };

        self.showLoginBox = function () {
            alert('You have to login first.');
        };

        self.ajaxErrorHandling = function (response, callBack, options) {
            if (this.isUndefined(response.status)) {
                alert('System Error: Undefined input.');

            } else {
                switch (response.status) {
                    case 'not-logged-in':
                        nbUtility.redirect();
                        break;

                    case 'already-logged-in':
                    case 'invalid':
                        alert(response.html);
                        break;

                    case 'error':
                        if (this.isUndefined(options) || !('errorCallback' in options)) {
                            alert(response.html);
                        } else {
                            var errorCallback = options.errorCallback;
                            this.isFunction(errorCallback) ? errorCallback() : null;
                        }
                        break;

                    case 'success':
                        this.isFunction(callBack) ? callBack(response, options) : null;
                        break;

                    default:
                        alert('Something went wrong. Please try again.');
                }
            }
        };

        function setModalConfig($loginModal) {
            $loginModal.modal('show').find('form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    email: {
                        required: 'Please enter your email address.',
                        email: 'Please enter a valid email address.'
                    },
                    password: {
                        required: 'Please provide a password.',
                        minlength: 'Your password must be at least 6 characters long.'
                    }
                },
                submitHandler: function (form) {
                    mySiteAjax({
                        url: $(form).attr('action'),
                        data: $(form).serialize(),
                        success: function (response) {
                            nbUtility.ajaxErrorHandling(response, function () {
                                $('#login-modal').on('hidden.bs.modal', function () {
                                    $(this).remove();
                                }).modal('hide');
                            }, {
                                errorCallback: function () {
                                    setModalConfig($loginModal.html($(response.html).html()));
                                }
                            });
                        }
                    });
                    return false;
                }
            });
        }

        return self;

    }(document, window.jQuery)) || window.nbUtility;

window.mySiteAjax = (function ($) {
    var urlCalled = [];
    return function (params) {
        var settings = $.extend({
                url: '',
                spinner: $('.loadingIt'),
                loadSpinner: true,
                dataType: 'json',
                cache: false,
                type: 'post',
                simultaneousRequest: false,
                success: function () {
                },
                beforeSend: function () {
                },
                complete: function () {
                },
                errorMsg: 'Oops. Sorry about that.'
            }, params),
            retries = 0;

        function ajaxRequest() {
            $.ajax({
                beforeSend: function () {
                    if (settings.loadSpinner) {
                        settings.spinner.show();
                    }
                    urlCalled[settings.url] = false;
                    nbUtility.isFunction(settings.beforeSend) ? settings.beforeSend() : null;
                },
                type: settings.type,
                url: settings.url,
                dataType: settings.dataType,
                success: settings.success,
                data: settings.data,
                complete: function () {
                    if (settings.loadSpinner) {
                        settings.spinner.hide();
                    }
                    urlCalled[settings.url] = true;
                    nbUtility.isFunction(settings.complete) ? settings.complete() : null;
                },
                error: function (xhr/*, tStatus, err*/) {
                    if (xhr.status === 401 || xhr.status === 403) {
                        //redirect action here
                    } else if (xhr.status === 504 && !retries++) {
                        //make our recursive request
                        ajaxRequest();
                    } else {
                        /*$(document).trigger( 'ui-flash-message',
                         [{ message: settings.errorMsg }] );*/
                    }
                } // end error handler
            }); // end $.ajax()
        } // end ajaxRequest()
        if (settings.simultaneousRequest) {
            ajaxRequest();
        } else if (nbUtility.isUndefined(urlCalled[settings.url]) || urlCalled[settings.url]) {
            ajaxRequest();
        }
    };
})(jQuery);

window.waitingDialog = (function ($) {

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div id="waiting-modal" class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');

    return {
        /**
         * Opens our dialog
         * @param message Custom message
         * @param options Custom options:
         *        options.dialogSize - bootstrap postfix for dialog size, e.g. 'sm', 'm';
         *        options.progressType - bootstrap postfix for progress bar type, e.g. 'success', 'warning'.
         */
        show: function (message, options) {
            (typeof message === 'undefined') ? message = 'Loading' : null;
            (typeof options === 'undefined') ? options = {} : null;

            // Assigning defaults
            var settings = $.extend({
                dialogSize: 'm',
                progressType: ''
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            $dialog.css('z-index', '1500');
            $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function () {
            //console.log(($dialog).html(''));
            $dialog.modal('hide');
        }
    }

})(jQuery);

window.customPopup = (function ($) {
    var defaultBtn = '<button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>';
    var $dialog = $(
        '<div id="custom-modal" class="modal fade modal-dark" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">' +
        '<div class="modal-dialog modal-md">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> ' +
        '<h3 style="margin:0;"></h3></div>' +
        '<div class="modal-body">' +
        '</div>' + '<div class="modal-footer"></div>'
        + '</div></div></div>');

    return {
        show: function (settings) {
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.modal-body').html(settings.message);
            $dialog.find('.modal-header h3').text(settings.header);
            if (settings.footer) {
                $dialog.find('.modal-footer').html(defaultBtn + settings.footer);
            } else {
                $dialog.find('.modal-footer').html(defaultBtn);
            }
            return $dialog.modal();
        },
        hideModal: function () {
            alert('s');
        }
    }

})(jQuery);

window.notification = {
    open: function (options, settings) {
        if (typeof options == 'object' && options.html != 'undefined') {

            if (options.html != 'undefined') {
                this.options.message = options.html;
            }

            if (options.status != 'undefined') {
                switch (options.status) {
                    case 'error':
                        this.settings.type = 'danger';
                        break;

                    case 'warning':
                        this.settings.type = 'warning';
                        break;

                    case 'success':
                        this.settings.type = 'success';
                        break;

                    default:
                        this.settings.type = 'info';

                }
            }
        }

        $.notify($.extend(this.options, options), $.extend(this.settings, settings));
    },
    options: {
        icon: '',
        title: '',
        message: 'Turning standard Bootstrap alerts into "notify" like notifications',
        url: '',
        target: '_blank'
    },
    settings: {
        element: 'body',
        position: null,
        type: '',
        allow_dismiss: false,
        newest_on_top: false,
        placement: {
            from: 'top',
            align: 'right'
        },
        offset: 20,
        spacing: 10,
        z_index: 40000000,
        delay: 1000,
        timer: 1000,
        url_target: '_blank',
        mouse_over: null,
        animate: {
            enter: 'animated fadeInDown',
            exit: 'animated fadeOutUp'
        },
        onShow: null,
        onShown: null,
        onClose: null,
        onClosed: null,
        icon_type: 'class',
        template: '<div data-notify="container" class="col-xs-11 col-sm-3 alert alert-{0}" role="alert">' +
        '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
        '<span data-notify="icon"></span> ' +
        '<span data-notify="title">{1}</span> ' +
        '<span data-notify="message">{2}</span>' +
        '<div class="progress" data-notify="progressbar">' +
        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
        '</div>' +
        '<a href="{3}" target="{4}" data-notify="url"></a>' +
        '</div>'
    }
};

$(function () {
    $('div.alert').delay(5000).slideUp(300);
});

window.generateErrorMessage = function ($form, mesages) {

    for (var elm in mesages) {
        if(!mesages[elm][0])
            continue;

        var formElement = $($form.submitEvent.target).find('[name="' + elm + '"]');

        if(!formElement.length)
            continue;

        var fromGroup   = formElement.closest('.form-group');
        var errorWarper = fromGroup.find('.col-md-6');
        fromGroup.removeClass('has-success').addClass('has-error');
        errorWarper.find('.help-block').remove();
        var errorsWrapper = $('<span>').attr({
            class: 'help-block'
        }).append($('<span>').html(mesages[elm][0]))
        errorWarper.append(errorsWrapper);
    }

}


window.SweetAlert = {
    defaultSettings: {
        title: "Are you sure?",
        text: "You will not be able to recover this data!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: true,
        closeOnCancel: true
    },
    confirm: function (settings, onSuccessCallback, onErrorCallback) {
        $.extend(true, this.defaultSettings, settings);

        return swal(this.defaultSettings, function (isConfirm) {
            if (isConfirm) {
                ($.isFunction(onSuccessCallback)) ? onSuccessCallback() : null;
            } else {
                ($.isFunction(onErrorCallback)) ? onErrorCallback() : null;
            }
        });
    },
    alert: function (message, status, title) {
        swal(
            (typeof title == 'undefined') ? '' : title,
            (typeof message == 'undefined') ? 'You clicked the button!' : message,
            (typeof status == 'undefined') ? 'success' : status
        )
    }
};


window.parsleySettings = (function (params) {
    var params = params || {};

    var settings = {
        successClass: 'has-success',
        inputs: 'input, textarea, select, password',
        errorClass: 'has-error',
        errorTemplate: '<span></span>',
        errorsWrapper: '<span class="help-block"></span>',
        classHandler: function (_el) {
            return _el.$element.closest('.form-group');
        }
    }

    return {
        settings: $.extend(settings, params)
    }
})();