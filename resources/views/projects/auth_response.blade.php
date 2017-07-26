@foreach($projects as $project)
    <div class="container-fluid tl-block project{{ $project['id'] }}">
        <div class="container">
            <div class="tl-head">
                <input type="hidden" name="project" value="/projects/{{ $project['id'] }}">
                <div class="col-md-1 text-center"><i class="glyphicon glyphicon-calendar"></i></div>
                <div class="col-md-9 tl-title">{{ $project['name'] }}</div>
                <div class="col-md-1"><i class="glyphicon glyphicon-pencil change-project-btn"></i></div>
                <div class="col-md-1"><i class="glyphicon glyphicon-trash remove-project"></i></div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-1 text-center"><i class="glyphicon glyphicon-plus"></i></div>
                <div class="col-md-8"><input type="text" class="form-control"></div>
                <div class="col-md-3">
                    <button class="btn btn-default add-task">Add Task</button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="tl-body">
                @foreach($projectlists[$project['name']] as $task)
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
                @endforeach
            </div>
        </div>
    </div>
@endforeach
@include('projects.modals')

