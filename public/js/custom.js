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
                success: function (data) {
                    setProjectlistsData(data);
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
                success: function (data) {
                    setProjectlistsData(data);
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

    $('#create-project').validate({
        rules: {
            name: 'required'
        },
        submitHandler: function () {
            var name = $('#new-project-name');
            $.ajax({
                url: '/projects',
                type: 'POST',
                data: {
                    name: name.val()
                },
                success: function (data) {
                    $('.new-project').modal('hide');
                    name.val('');
                    $(data).insertBefore('.add-project-block');
                },
                error: function () {
                    console.log('Something wrong');
                }

            });
        },
        invalidHandler: function () {
            console.log('error');
        },
        errorPlacement: function(error, element) {
            var myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });

    bindProjectKeys();
    bindTaskKeys();

    $('#change-project').validate({
        rules: {
            name: 'required'
        },
        submitHandler: function () {
            $.ajax({
                url: $('#change-project input[name=project]').val(),
                type: 'PATCH',
                data: {
                    name: $('#change-project input[name=name]').val()
                },
                success: function (data) {
                    $('.project-name').modal('hide');
                    $('.project' + data['id'] + ' .tl-title').text(data['name']);
                    bindProjectKeys();
                },
                error: function () {
                    console.log('Something wrong');
                }

            });
        },
        invalidHandler: function () {
            console.log('error');
        },
        errorPlacement: function(error, element) {
            var myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });

    $('#change-task').validate({
        rules: {
            content: 'required'
        },
        submitHandler: function () {
            $.ajax({
                url: '/tasks/' + $('#change-task input[name=task]').val(),
                type: 'PATCH',
                data: {
                    content: $('#change-task input[name=content]').val()
                },
                success: function (data) {
                    $('.task-name').modal('hide');
                    $('.task' + data['id'] + ' .task-content').text(data['content']);
                },
                error: function () {
                    console.log('Something wrong');
                }

            });
        },
        invalidHandler: function () {
            console.log('error');
        },
        errorPlacement: function(error, element) {
            var myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });


});

function bindProjectKeys() {
    $('div#app').off();
    $('div#app').on('click', '.change-project-btn', function() {
        $('.project-name').modal('show');
        $('#change-project input[name=project]').val($(this).parent().siblings('input[name=project]').val());
        $('#change-project input[name=name]').val($(this).parent().siblings('.tl-title').text());
    });

    $('div#app').on('click', 'i.remove-project', function() {
        var url = $(this).parent().siblings('input[name=project]').val();
        var list = $(this).closest('.container-fluid.tl-block');
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function () {
                list.remove();
            },
            error: function () {
                console.log('Smthing wrong!')
            }
        });
    });

}

function bindTaskKeys() {
    $('body').off();
    $('body').on('click', '.change-task-btn', function () {
        $('.task-name').modal('show');
        $('#change-task input[name=task]').val($(this).parent().siblings('input[name=task_id]').val());
        $('#change-task input[name=content]').val($(this).parent().siblings('.task-content').text());
    });

    $('body').on('click', '.task .glyphicon-trash', function () {
        var url = 'tasks/' + $(this).parent().siblings('input[name=task_id]').val();
        var task = $(this).closest('.task');
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function () {
                task.remove();
            },
            error: function () {
                console.log('Smthing wrong!')
            }
        });
    });


}

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

function setProjectlistsData(data) {
    $('div#app').html(data);
}