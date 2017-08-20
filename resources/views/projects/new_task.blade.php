<div class="task task{{ $task['id'] }}">
    <input type="hidden" name="task_id" value="{{ $task['id'] }}">
    <input type="hidden" name="order" value="{{ $task['order'] }}">
    <div class="col-md-1 text-center">
        <input type="checkbox" id="done-status{{ $task['id'] . $task['order'] }}" class="is-done" @if($task['is_done']) checked @endif>
        <label for="done-status{{ $task['id'] . $task['order'] }}"></label>
    </div>
    <div class="col-md-6 task-content">{{ $task['content'] }}</div>
    <div class="col-md-1 ordering text-center">
        <i class="glyphicon glyphicon-chevron-up"></i>
        <i class="glyphicon glyphicon-chevron-down"></i>
    </div>
    <div class="col-md-2 text-center">
        <input type="date" class="deadline" value="{{ $task['deadline'] }}">
    </div>
    <div class="col-md-1 text-center"><i class="glyphicon glyphicon-pencil change-task-btn"></i></div>
    <div class="col-md-1 text-center"><i class="glyphicon glyphicon-trash"></i></div>
</div>