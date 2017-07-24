<div class="container-fluid text-center add-project-block">
    <button class="btn btn-primary" data-toggle="modal" data-target=".new-project">Add TODO list</button>

    <div class="modal fade new-project" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="create-project">
                    <input type="text" class="form-control" id="new-project-name" name="name" placeholder="List name">
                    <button type="submit" id="new-project" class="btn btn-primary">Add</button>
                </form>

            </div>
        </div>
    </div>
</div>