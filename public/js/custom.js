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
        submitHandler: function () {
            $.ajax({
                url: '/register',
                data: getRegistrationData(),
                type: 'POST',
                success: function () {
                    console.log('All good');
                },
                error: function() {
                    console.log('Something gonna bad');
                }
            });
        },
        invalidHandler: function () {
            console.log('error');
        },
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
        submitHandler: function () {
            $.ajax({
                url: '/login',
                data: getAuthData(),
                type: 'POST',
                success: function () {
                    console.log('All good');
                },
                error: function() {
                    console.log('Something gonna bad');
                }
            });
        },
        invalidHandler: function () {
            console.log('error');
        },
        errorPlacement: function(error, element) {
            let myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });

});

function getRegistrationData() {
    return {
        name: $('#name').val(),
        email: $('#email').val(),
        password: $('#password').val(),
        password_confirmation: $('#password-confirm').val()
    }
}

function getAuthData() {
    return {
        email: $('#email').val(),
        password: $('#password').val()
    }
}