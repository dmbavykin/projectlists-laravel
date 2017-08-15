<h1 class="text-center">TODO lists</h1>
@foreach($projects as $project)
    <div class="container-fluid tl-block project{{ $project['id'] }}">
        <div class="container tl-head-block">
            <div class="tl-head">
                <input type="hidden" name="project" value="{{ $project['id'] }}">
                <div class="col-md-1 text-center"><i class="glyphicon glyphicon-calendar"></i></div>
                <div class="col-md-9 tl-title">{{ $project['name'] }}</div>
                <div class="col-md-1"><i class="glyphicon glyphicon-pencil change-project-btn"></i></div>
                <div class="col-md-1"><i class="glyphicon glyphicon-trash remove-project"></i></div>
            </div>
        </div>
        <div class="container">
            <div class="add-task-block">
                <div class="col-md-1 text-center"><i class="glyphicon glyphicon-plus"></i></div>
                <div class="col-md-8"><input type="text" name="content" class="form-control task-adding"></div>
                <div class="col-md-3">
                    <button class="btn btn-default add-task">Add Task</button>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="tl-body">
                @foreach($projectlists[$project['name']] as $task)
                    @include('projects.new_task')
                @endforeach
            </div>
        </div>
    </div>
@endforeach
@include('projects.modals')

