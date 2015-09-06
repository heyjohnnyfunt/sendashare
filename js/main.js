/**
 * Created by skogs on 04.09.2015.
 */
$(document).ready(main);

function main() {
    //formControl();
}

function formControl() {
    $('form#login').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        $.ajax({
            type: 'POST',
            url: window.location.protocol + '//' + window.location.host + '/login/ajaxCheck',
            data: data,
            success: function (data) {
                window.location.href = window.location.protocol + '//' + window.location.host + '/' + data;
            },
            error: function (a) {
                console.log(a);
            }
        });
        return false;
    });
}