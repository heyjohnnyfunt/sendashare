/**
 * Created by skogs on 04.09.2015.
 */
$(document).ready(main);

function main() {
    //formControl();
    ajaxCheckTemplate('login','username');
    ajaxCheckTemplate('registration','username');
    ajaxCheckTemplate('registration','email');
}

function ajaxCheckTemplate($formId, $elementId){
    $('form#' + $formId + ' #' + $elementId).change(function (e) {
        var self = $(this);
        var selfId = self.attr('id');
        var $loader = self.siblings('.form-loader-icon');
        $loader.show();
        var data = selfId + '=' + self.val();

        var ajaxPhp = '', helloMsg = '', fuckMsg = '';
        switch ($formId){
            case 'login':
                ajaxPhp = 'checkUsernameLogin';
                helloMsg = 'Username or email is not valid';
                fuckMsg = 'Username or email is valid';
                break;
            case 'registration':
                if($elementId === 'username'){
                    ajaxPhp = 'checkUsernameReg';
                    helloMsg = 'Choose another username';
                    fuckMsg = 'Username is valid';
                }
                else if ($elementId === 'email'){
                    ajaxPhp = 'checkUserEmailReg';
                    helloMsg = 'This Email already registered';
                    fuckMsg = 'Email is valid';
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
                if (data === 'N')
                    self.parent().next('p').removeClass().addClass('error text-center').html(helloMsg);
                else if (data === 'Y')
                    self.parent().next('p').removeClass().addClass('good text-center').html(fuckMsg);
            },
            error: function (a) {
                console.log(a);
            }
        });
        return false;
    });
}

function formControl() {
    /*$('form#login').submit(function (e) {
     e.preventDefault();
     $("#loaderIcon").show();
     var data = 'username=' + $(this).find('#username').val();
     $.ajax({
     type: 'POST',
     url: window.location.protocol + '//' + window.location.host + '/login/ajaxCheck',
     data: data,
     success: function (data) {
     $("#user-availability-status").html(data);
     $("#loaderIcon").hide();
     //window.location.href = window.location.protocol + '//' + window.location.host + '/' + data;
     },
     error: function (a) {
     console.log(a);
     }
     });
     return false;
     });*/

    $('form#login #username').change(function (e) {
        var self = $(this);
        var $loader = self.siblings('.form-loader-icon');
        $loader.show();
        var data = 'username=' + self.val();
        $.ajax({
            type: 'POST',
            url: window.location.protocol + '//' + window.location.host + '/login/checkUsernameLogin',
            data: data,
            success: function (data) {
                $loader.hide();
                if (data === 'N')
                    self.parent().next('p').removeClass().addClass('error text-center').html('Username or email is not valid');
                else if (data === 'Y')
                    self.parent().next('p').removeClass().addClass('good text-center').html('Username or email is valid');
            },
            error: function (a) {
                console.log(a);
            }
        });
        return false;
    });

    $('form#registration #username').change(function (e) {
        var self = $(this);
        var selfId = self.attr('id');
        var $loader = self.siblings('.form-loader-icon');
        $loader.show();
        var data = selfId + '=' + self.val();

        $.ajax({
            type: 'POST',
            url: window.location.protocol + '//' + window.location.host + '/login/checkUsernameReg',
            data: data,
            success: function (data) {
                $loader.hide();
                if (data === 'N')
                    self.parent().next('p').removeClass().addClass('error text-center').html('Choose another username');
                else if (data === 'Y')
                    self.parent().next('p').removeClass().addClass('good text-center').html('Username is valid');
            },
            error: function (a) {
                console.log(a);
            }
        });
        return false;
    });

    $('form#registration #email').change(function (e) {
        var self = $(this);
        var selfId = self.attr('id');
        var $loader = self.siblings('.form-loader-icon');
        $loader.show();
        var data = selfId + '=' + self.val();

        $.ajax({
            type: 'POST',
            url: window.location.protocol + '//' + window.location.host + '/login/checkUserEmailReg',
            data: data,
            success: function (data) {
                $loader.hide();
                if (data === 'N')
                    self.parent().next('p').removeClass().addClass('error text-center').html('This Email already registered');
                else if (data === 'Y')
                    self.parent().next('p').removeClass().addClass('good text-center').html('Email is valid');
            },
            error: function (a) {
                console.log(a);
            }
        });
        return false;
    });
}