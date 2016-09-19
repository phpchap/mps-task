<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>Add a new task</h4>
        </div>
        <div class="panel-body">
            <form id="add_task" action="{{ route('add_new_task') }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control" id="name" placeholder="title" name="title" value="{{ old('title') }}">
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" placeholder="Description" name="description" value="{{ old('description') }}"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Add a new task</button>
            </form>
        </div>
    </div>
</div>