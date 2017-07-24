<div class="container-fluid text-center add-list-block">
    <button class="btn btn-primary" data-toggle="modal" data-target=".new-list">Add TODO list</button>

    <div class="modal fade new-list" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <form id="create-list">
                    <input type="text" class="form-control" id="new-list-name" name="name" placeholder="List name">
                    <button type="submit" id="new-list" class="btn btn-primary">Add</button>
                </form>

            </div>
        </div>
    </div>
</div>