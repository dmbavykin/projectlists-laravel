<div class="container-fluid tl-block project{{ $id }}">
    <div class="container">
        <div class="tl-head">
            <input type="hidden" name="project" value="{{ $id }}">
            <div class="col-md-1 text-center"><i class="glyphicon glyphicon-calendar"></i></div>
            <div class="col-md-9 tl-title">{{ $name }}</div>
            <div class="col-md-1"><i class="glyphicon glyphicon-pencil change-project-btn"></i></div>
            <div class="col-md-1"><i class="glyphicon glyphicon-trash remove-project"></i></div>
        </div>
    </div>
    <div class="container">
        <div class="add-task-block">
            <div class="col-md-1 text-center"><i class="glyphicon glyphicon-plus"></i></div>
            <div class="col-md-8"><input type="text" name="content" class="form-control"></div>
            <div class="col-md-3">
                <button class="btn btn-default add-task">Add Task</button>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="tl-body"></div>
    </div>
</div>