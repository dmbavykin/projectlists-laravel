$(function () {
    bindProjectKeys();
    bindTaskKeys();
    $('#new-project').click(function () {
        formHandler('#create-project', {name: 'required'}, ajax.create_project);
    });
    $('#change-project-btn').click(function () {
        formHandler('#change-project', {name: 'required'}, ajax.change_project);
    });
    $('#change-task-btn').click(function () {
        formHandler('#change-task', {content: "required"}, ajax.change_task);
    });
    $('#new-project-name').change(function () {
        ajax.create_project.data.name = $(this).val();
    });
    $('#change-project input[name=name]').change(function () {
        ajax.change_project.data.name = $(this).val();
        ajax.change_project.url = '/projects/' + $('#change-project input[name=project]').val();
    });
    $('#change-task input[name=content]').change(function () {
        ajax.change_task.data.content = $('#change-task input[name=content]').val();
        ajax.change_task.url = '/tasks/' + $('#change-task input[name=task]').val();
    });
});
var ajax = {
    create_project: {
        url: '/projects',
        type: 'POST',
        data: {
            name: ''
        },
        success: function (data) {
            if (!data) return false;
            $('.new-project').modal('hide');
            $('new-project-name').val('');
            $(data).insertBefore('.add-project-block');
            bindProjectKeys();
        },
        error: function () {
            showErrorInsideModal('.new-project', 'Project isn`t created');
        }
    },
    change_project : {
        url: '',
        type: 'PATCH',
        data: {
            name: ''
        },
        success: function (data) {
            if (!data) return false;
            $('.project-name').modal('hide');
            $('.project' + data['id'] + ' .tl-title').text(data['name']);
            bindProjectKeys();
        },
        error: function () {
            showErrorInsideModal('.project-name', 'Project wasn`t renamed');
        }
    },
    change_task: {
        url: '',
        type: 'PATCH',
        data: {
            content: ''
        },
        success: function (data) {
            if (!data) return false;
            $('.task-name').modal('hide');
            $('.task' + data['id'] + ' .task-content').text(data['content']);
        },
        error: function () {
            showErrorInsideModal('.task-name', 'Task wasn`t changed');
        }
    }
};

function bindProjectKeys() {
    $('#app').off();
    $('#app').on('click', '.change-project-btn', function() {
        $('.project-name').modal('show');
        $('#change-project input[name=project]').val($(this).parent().siblings('input[name=project]').val());
        $('#change-project input[name=name]').val($(this).parent().siblings('.tl-title').text());
    });
    $('#app').on('click', 'i.remove-project', function() {
        var url = '/projects/' + $(this).parent().siblings('input[name=project]').val();
        var list = $(this).closest('.container-fluid.tl-block');
        $.ajax({
            url: url,
            type: 'DELETE',
            success: function (data) {
                data > 0 ? list.remove() : modalError('Project wasn`t found');
            },
            error: function () {
                modalError('Project wasn`t removed');
            }
        });
    });
    $('#app').on('click', '.add-task', function () {
        var content = $(this).closest('.add-task-block').find('input');
        var order = $(this).closest('.tl-block').find('input[name=order]:last').val();
        var project_id = $(this).closest('.tl-block').find('input[name=project]').val();
        var append_target = $(this).closest('.tl-block').find('.tl-body');
        if (content.val()) {
            $.ajax({
                url: '/tasks',
                type: 'POST',
                data: {
                    content: content.val(),
                    order: order ? +order + 1 : 1,
                    project_id: project_id
                },
                success: function (data) {
                    content.val('');
                    append_target.append(data);
                    bindTaskKeys();
                },
                error: function () {
                    console.log('Something wrong');
                }
            });
        }
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
            success: function (data) {
                data > 0 ? task.remove() : modalError('Task wasn`t found');
            },
            error: function () {
                modalError('Task wasn`t removed');
            }
        });
    });
    $('body').on('click', '.is-done', function () {
        var url = '/tasks/done/' + $(this).closest('.task').find('input[name=task_id]').val();
        $.ajax({
            url: url,
            type: 'POST'
        });
    });
    $('body').on('click', '.ordering .glyphicon', function () {
        var task =  $(this).closest('.task');
        var target_id = task.find('input[name=task_id]').val();
        var target_order = task.find('input[name=order]').val();
        var direction = $(this).hasClass('glyphicon-chevron-up');
        var replacement = direction ? task.prev() : task.next();
        var replacement_id = replacement.find('input[name=task_id]').val();
        var replacement_order = replacement.find('input[name=order]').val();
        if (replacement_id) {
            $.ajax({
                url: '/tasks/order',
                type: 'POST',
                data: {
                    target_id: target_id,
                    replacement_id: replacement_id
                },
                success: function (data) {
                    if (!data) return false;
                    task.remove();
                    task.find('input[name=order]').val(replacement_order);
                    replacement.find('input[name=order]').val(target_order);
                    direction ? task.insertBefore(replacement) : task.insertAfter(replacement);
                },
                error: function () {
                    modalError('Order wasn`t changed');
                }
            });
        }
    });

    $('body').on('change', '.deadline', function () {
        var deadline = $(this).val();
        var task_id = $(this).closest('.task').find('input[name=task_id]').val();
        $.ajax({
            url: '/tasks/deadline',
            type: 'POST',
            data: {
                deadline: deadline,
                id: task_id
            }
        });
    });
}

function formHandler(selector, rules, ajax) {
    $(selector).validate({
        rules: rules,
        submitHandler: function () {
            $.ajax(ajax);
        },
        invalidHandler: function () {
            console.log('error');
        },
        errorPlacement: function(error, element) {
            var myElem = $.inArray(element.attr("name"), ['fname', 'lname']) ? element : '#lastname';
            error.insertBefore(myElem);
        }
    });
}

function showErrorInsideModal(selector, text) {
    $(selector + ' .modal-content').prepend('<span class="text-danger">' + text + '</span>');
    setTimeout(function () {
        $(selector + ' .modal-content').find('span.text-danger').remove();
    }, 3000);
}

function modalError(text) {
    $('.error-modal .modal-content').html('<div class="row text-center text-danger">' + text + '</div>');
    $('.error-modal').modal('show');
    setTimeout(function () {
        $('.error-modal').modal('hide');
    }, 3000);
}