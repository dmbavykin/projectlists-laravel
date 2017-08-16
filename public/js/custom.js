$(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    formValidaton('#login-form', auth_rules);
    formValidaton('#register-form', register_rules);
});

function formValidaton(selector, rules) {
    $(selector).validate({
        rules: rules,
        errorElement: 'div',
        errorClass: "text-danger",
        validClass: 'input-success',
        errorPlacement: function(error, element) {
            var myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });
}

var auth_rules = {
    email: {
        required: true,
        email: true,
        minlength: 6
    },
    password: {
        required: true,
        minlength: 6
    }
};

var register_rules = {
    name: {
        required: true,
        minlength: 2
    },
    password: auth_rules.password,
    email: auth_rules.email,
    password_confirmation: {
        required: true,
        equalTo: "#password"
    }
};