<div class="task task{{ $task['id'] }}">
    <input type="hidden" name="task_id" value="{{ $task['id'] }}">
    <input type="hidden" name="order" value="{{ $task['order'] }}">
    <div class="col-md-1">
        <input type="checkbox">
    </div>
    <div class="col-md-8 task-content">{{ $task['content'] }}</div>
    <div class="col-md-1"></div>
    <div class="col-md-1"><i class="glyphicon glyphicon-pencil change-task-btn"></i></div>
    <div class="col-md-1"><i class="glyphicon glyphicon-trash"></i></div>
</div>