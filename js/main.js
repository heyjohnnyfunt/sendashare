/**
 * Created by skogs on 04.09.2015.
 */
$(document).ready(main);

function main() {

    new Login().formControl();

    var settings = new Settings();
    settings.set();
}

function Login() {

    this.formControl = function () {
        login();
        registration();
        ajaxCheckTemplate('login', 'username');
        ajaxCheckTemplate('registration', 'username');
        ajaxCheckTemplate('registration', 'email');
    };

    var $login = $('#login');
    var $reg = $('#registration');

    function login() {
        if (!$login.length) return;

        $login.submit(function (event) {

            event.preventDefault();
            var $p = $login.siblings('p');
            if ($p.size() < 1)
                $p = $('<p/>').addClass('pull-left error').insertAfter($login);
            $p.hide();

            var data = validateLoginInput();
            if (data === false) {
                $p.html('Check your input').show();
                return;
            }

            var $loader = Helper.insertBigLoader();

            $.ajax({
                method: 'POST',
                url: window.location.protocol + '//' + window.location.host + '/login/ajaxLogin',
                data: data,
                beforeSend: function () {
                    $loader.fadeIn();
                },
                success: function (data) {
                    if (data == 'N') {
                        $p.html('Invalid username/email or password').show();
                    } else window.location.href = data;
                },
                error: function () {
                    $p.html('Check your Internet connection').show();
                },
                complete: function () {
                    $loader.fadeOut();
                }
            });

        });
    }

    function registration() {
        if (!$reg.length) return;

        Validator.comparePass($reg, $reg.find('input[name=password]'), $reg.find('input[name=confPassword]'));
        Validator.checkPass($reg.find('input[name=password]'));

        $reg.on('submit', function (event) {

            event.preventDefault();
            var $p = $reg.siblings('p');
            if ($p.size() < 1)
                $p = $('<p/>').addClass('pull-left error').insertAfter($reg);
            $p.hide();

            var data = validateRegInput();
            if (data === false) {
                $p.html('Check your input').show();
                return;
            }

            var $loader = Helper.insertBigLoader();

            $.ajax({
                method: 'POST',
                url: window.location.protocol + '//' + window.location.host + '/login/ajaxRegister',
                data: data,
                beforeSend: function () {
                    $loader.fadeIn();
                },
                success: function (data) {
                    if (data == 'N') {
                        $p.html('Registration failed. Check your input').show();
                    } else window.location.href = data;
                },
                error: function () {
                    $p.html('Check your Internet connection').show();
                },
                complete: function () {
                    $loader.fadeOut();
                }
            });
        });
    }

    function validateLoginInput() {
        var username = strip_tags($login.find('input[name=username]').val());
        if (username.length < 2) return false;

        var password = $login.find('input[name=password]').val();
        if (password.length < 6) return false;

        var data = {
            username: username,
            password: hex_sha256(password)
        };

        var redirect = $login.find('input[name=redirect]');
        if (redirect.size() > 0) {
            data.redirect = redirect.val();
        }

        data.remember_me = $login.find('input[name=remember_me]').val();

        return data;
    }

    function validateRegInput() {
        var username = strip_tags($reg.find('input[name=username]').val());
        if (username.length < 2) return false;

        var email = strip_tags($reg.find('input[name=email]').val());
        if (email.length < 6) return false;

        /*var password = strip_tags($reg.find('input[name=password]').val());
         if (password.length < 6) return false;

         var confPass = strip_tags($reg.find('input[name=confPassword]').val());
         if (password.length < 6) return false;

         if (password !== confPass) return false;*/

        var data = {
            username: username,
            email: email,
            firstname: strip_tags($reg.find('input[name=firstname]').val()),
            lastname: strip_tags($reg.find('input[name=lastname]').val())
            /*password: hex_sha256(password),
             confPassword: hex_sha256(confPass)*/
        };

        var passData = Helper.validatePass($reg.find('input[name=password]'), $reg.find('input[name=confPassword]'))


        if (passData === false) return false;

        for (var prop in passData) {
            if (passData.hasOwnProperty(prop))
                data[prop] = passData[prop];
        }

        var redirect = $login.find('input[name=redirect]');
        if (redirect.size() > 0) {
            data.redirect = redirect.val();
        }

        return data;
    }

    function ajaxCheckTemplate(formId, elementId) {
        $('form#' + formId + ' #' + elementId).change(function () {
            var self = $(this);
            var selfId = self.attr('id');

            var $loader = self.siblings('.form-loader-icon');
            $loader.show();

            var $p = insertHint(self);

            var data = selfId + '=' + strip_tags(self.val());

            var ajaxPhp = '', fuckMsg = '';
            switch (formId) {
                case 'login':
                    ajaxPhp = 'checkUsernameLogin';
                    fuckMsg = 'Username or email is not valid';
                    break;
                case 'registration':
                    if (elementId === 'username') {
                        ajaxPhp = 'checkUsernameReg';
                        fuckMsg = 'Choose another username';
                    }
                    else if (elementId === 'email') {
                        ajaxPhp = 'checkUserEmailReg';
                        fuckMsg = 'Choose another Email';
                    }
                    break;
                default:
                    ajaxPhp = 'checkUsernameLogin';
                    break;
            }

            $.ajax({
                type: 'POST',
                url: window.location.protocol + '//' + window.location.host + '/login/' + ajaxPhp,
                data: data,
                success: function (data) {
                    $loader.hide();
                    $p.show();

                    if (data === 'N') {
                        $p.removeClass('good').addClass('error').html(fuckMsg);
                    }
                    else if (data === 'Y') {
                        $p.removeClass('error').addClass('good').html('✔');
                    }
                },
                error: function (a) {
                    console.log(a);
                }
            });
            return false;
        });
    }

    function insertHint(nearbyElement) {
        var $p = nearbyElement.siblings('p');
        if ($p.size() < 1)
            $p = $('<p/>').addClass('form-hint').insertAfter(nearbyElement);
        $p.hide();
        return $p;
    }
}

function Settings() {

    this.set = function () {
        updateSettings('username');
        updateSettings('email');
        updateSettings('firstname');
        updateSettings('lastname');
        updatePassword();
    };

    var $settings = $("#settings");

    function updateSettings(inputId) {
        if (!$settings.length) return;

        $settings.find('#' + inputId).change(function () {
            var self = $(this);
            var selfId = self.attr('id');

            var $loader = self.siblings('.form-loader-icon');
            $loader.show();

            var $p = self.siblings('p');
            if ($p.size() < 1)
                $p = $('<p/>').addClass('form-hint').insertAfter(self);
            $p.hide();

            var data = selfId + '=' + strip_tags(self.val());

            var ajaxPhp = '', fuckMsg = '';
            switch (inputId) {
                case 'username':
                    ajaxPhp = 'saveUsername';
                    fuckMsg = 'Choose another username';
                    break;
                case 'email':
                    ajaxPhp = 'saveEmail';
                    fuckMsg = 'Choose another Email';
                    break;
                case 'firstname':
                    ajaxPhp = 'saveFirstName';
                    break;
                case 'lastname':
                    ajaxPhp = 'saveLastName';
                    break;
                default:
                    ajaxPhp = '';
                    break;
            }

            $.ajax({
                type: 'POST',
                url: window.location.protocol + '//' + window.location.host + '/account/' + ajaxPhp,
                data: data,
                success: function (data) {
                    $loader.hide();
                    $p.show();

                    if (data === 'USER_EXISTS' || data === 'EMAIL_EXISTS')
                        $p.removeClass('good').addClass('error').html(fuckMsg);
                    else if (data === 'NOT_UPDATED')
                        $p.removeClass('good').addClass('error').html('Error while update. Sorry :(');
                    else if (data === 'Y')
                        $p.removeClass('error').addClass('good').html('✔');
                }
            });
        });
    }

    function updatePassword() {
        if (!$settings.length) return;

        var self = $settings;
        var pass = self.find('input[name=password]');
        var confPass = self.find('input[name=confPassword]');

        Validator.comparePass(self, pass, confPass);
        Validator.checkPass(pass);

        self.find('form#changePassword').on('submit', function (event) {

            event.preventDefault();
            var form = $(this);
            var $p = form.children('p');
            if ($p.size() < 1)
                $p = $('<p/>').appendTo(form);
            $p.hide();

            var data = Helper.validatePass(pass, confPass);
            if (data === false) {
                $p.html('Check your passwords').show();
                return;
            }

            var $loader = Helper.insertBigLoader();

            //var data = pass.attr('id') + '=' + pass.val();
            $.ajax({
                method: 'POST',
                url: window.location.protocol + '//' + window.location.host + '/account/changePassword',
                data: data,
                beforeSend: function () {
                    $loader.fadeIn();
                },
                success: function (data) {
                    $p.show();
                    if (data === 'NOT_UPDATED')
                        $p.removeClass('good').addClass('error').html('Error while update. Sorry :(');
                    else if (data === 'Y')
                        $p.removeClass('error').addClass('good').html('Password changed successfully').fadeOut(6000);
                },
                error: function () {
                    $p.html('Check your Internet connection').show();
                },
                complete: function () {
                    $loader.fadeOut(function () {
                        $(this).remove();
                    });
                }
            });
        });
    }
}

var Validator = (function () {

    var compareVals = function (psw1, psw2) {
        return psw1.val() === psw2.val();
    };

    var validatePass = function (psw) {
        return psw.val().length >= 6;
    };
    return {
        comparePass: function (form, pass, confPass) {
            form.find('input[name=password], input[name=confPassword]').keyup(function () {
                if (!compareVals(pass, confPass)) {
                    confPass.addClass('error-input');
                } else {
                    confPass.removeClass('error-input');
                }
            });
        },

        checkPass: function (pass) {
            var $p = pass.siblings('p');
            if ($p.size() < 1)
                $p = $('<p/>').addClass('form-hint').insertAfter(pass).show();

            pass.change(function () {
                validatePass(pass) ? $p.removeClass('error').addClass('good').html('✔') && pass.removeClass('error-input')
                    : $p.removeClass('good').addClass('error').html('Min 6 symbols') && pass.addClass('error-input');
            })
        }
    }
})();

var Helper = (function () {

    return {
        validatePass: function (pass, confPass) {
            pass = pass.val();
            if (pass.length < 6) return false;

            confPass = confPass.val();
            if (confPass.length < 6) return false;

            if (pass !== confPass) return false;

            return {
                password: hex_sha256(pass),
                confPassword: hex_sha256(confPass)
            };
        },

        insertBigLoader: function () {
            var $bg = $('<div/>').addClass('popup-bg');
            var $loader = $('<div/>').addClass('popup-loader');
            $loader.appendTo($bg);
            $bg.appendTo($(document.body)).hide();

            return $bg;
        }
    }

})();

function strip_tags(str) {
    return str.replace(/<\/?[^>]+>/gi, '');
}

(function () {

    var form = $('#dropZone-form'),
        fileList = form.siblings('#files');

    var dropZone = $('form > #dropZone'),
        span = dropZone.children('span'),
        maxsize = 100 * 1024 * 1024; // максимальный размер фалйа - 100 мб.

    if (dropZone.length < 1) return;

    form.on('click', '[type=submit]', function (event) {
        event.preventDefault();
        var file_data = $("#fileToUpload").prop("files");

        //formData.append("fileToUpload", file_data);
        $.ajax({
            method: 'POST',
            url: window.location.protocol + '//' + window.location.host + '/account/ajaxUpload',
            //dataType: 'script',
            cache: false,
            contentType: false,
            processData: false,
            data: sendFiles(file_data),
            success: function (data) {
                console.log(data);
            },
            error: function (data) {
                console.log(data);
            },
            complete: function () {
                var fileInput = $("#fileToUpload");
                fileInput.replaceWith(fileInput.clone(true));
            }
        });
    });


    // Проверка поддержки браузером
    if (typeof(window.FileReader) == 'undefined') {
        createSimpleUpload();
        return;
    }

    // Добавляем класс hover при наведении
    dropZone[0].ondragover = function () {
        dropZone.addClass('hover');
        return false;
    };

    // Убираем класс hover
    dropZone[0].ondragleave = function () {
        dropZone.removeClass('hover');
        return false;
    };

    // Обрабатываем событие Drop
    dropZone[0].ondrop = function (event) {
        event.preventDefault();
        dropZone.removeClass('hover');
        dropZone.addClass('drop');

        sendFiles(event.dataTransfer.files);

    };

    // Показываем процент загрузки
    function uploadProgress(event, progressBar) {
        if (!event.lengthComputable) return;

        var percent = parseInt(event.loaded / event.total * 100);
        progressBar.css('width', percent + '%');
    }

    // Пост обрабочик
    /*function stateChange(event) {
     if (event.target.readyState == 4) {
     if (event.target.status == 200) {
     span.html(event.target.responseText);
     } else {
     span.text('Error accured..');
     span.addClass('error');
     }
     }
     }*/

    function addFile(index, file) {
        var p = $('<p/>').text(file.name + ' is uploading...'),
            progressBar = $('<div/>').addClass('progress-bar'),
            progress = $('<div/>').addClass('progress'),
            div = $('<div/>').attr('data-id', index);

        p.appendTo(div);
        progress.append(progressBar).appendTo(div);
        div.appendTo(fileList).show();
        return div;
    }

    function sendFiles(file_data) {

        $.each(file_data, function (index, file) {

            var formData = new FormData();                  // Creating object of FormData class
            // Проверяем размер файла
            if (file.size > maxsize) {
                span.text(file.name + ' is too big. Max size: 100Mb, max number of files: 20.');
                dropZone.addClass('error');
                return false;
            }
            formData.append('fileToUpload', file, file.name);
            var fileDiv = addFile(index, file),
                progressBar = fileDiv.find('.progress-bar');

            $.ajax({
                xhr: function () {
                    var xhr = new XMLHttpRequest();
                    xhr.upload.onprogress = function (event) { // uploadProgress;
                        var percent = parseInt(event.loaded / event.total * 100);
                        progressBar.css('width', percent + '%');
                    };
                    //xhr.onreadystatechange = stateChange;
                    return xhr;
                },
                method: 'POST',
                url: window.location.protocol + '//' + window.location.host + '/account/ajaxUpload',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (data) {
                    if (data !== 'N')
                        fileDiv.find('p').text(file.name + ' uploaded');
                    else
                        fileDiv.find('p').addClass('error').text(file.name + ' is NOT uploaded. Try again..');
                },
                error: function (data) {
                    fileDiv.find('p').text('Error occurred. ' + file.name + ' was NOT sent');
                }
            });
        });
    }

    function createSimpleUpload() {
        span.text('Your browser is not supporting Drag&Drop technology. ' +
            'You can manually add files');
        dropZone.addClass('error');
        $('<input>').attr({
            type: 'file',
            id: 'fileToUpload',
            name: 'fileToUpload[]',
            value: 'Upload new file',
            multiple: 'multiple',
            enctype: 'multipart/form-data'
        }).appendTo(dropZone);
        $('<input>').attr({
            type: 'submit',
            value: 'Upload',
            name: 'submit'
        }).appendTo(dropZone);
    }

})();
