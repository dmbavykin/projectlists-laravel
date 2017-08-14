$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#register-form').validate({
        rules: {
            name: {
                required: true,
                minlength: 2
            },
            password: {
                required: true,
                minlength: 6
            },
            email: "required",
            password_confirmation: {
                required: true,
                equalTo: "#password"
            }
        },
        errorElement: 'div',
        errorClass: "text-danger",
        validClass: 'input-success',
        errorPlacement: function(error, element) {
            let myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });

    $('#login-form').validate({
        rules: {
            email: {
                required: true,
                email: true,
                minlength: 6

            },
            password: {
                required: true,
                minlength: 6
            }
        },
        errorElement: 'div',
        errorClass: "text-danger",
        validClass: 'input-success',
        errorPlacement: function(error, element) {
            let myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });

});