@extends('layouts.master')

@section('title')
MPS :: Tasks
@endsection

@section('content')

<div class="container">

    <div class="row">

        @include('includes.title')
        @include('includes.messages')
        @include('forms.add_task')

        <!-- NEW TASKS -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-check"></i> New </h4>
                </div>
                <div class="panel-body" id="todo_tasks">
                    @include('tasks.new', ['tasks' => $newTasks])
                </div>
            </div>
        </div>

        <!-- IN PROGRESS TASKS -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-gift"></i> In Progress</h4>
                </div>
                <div class="panel-body" id="doing_tasks">
                    @include('tasks.inProgress', ['tasks' => $inProgressTasks])
                </div>
            </div>
        </div>

        <!-- DONE TASKS -->
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4><i class="fa fa-fw fa-compass"></i> Completed</h4>
                </div>
                <div class="panel-body" id="completed_tasks">
                    @include('tasks.done', ['tasks' => $completedTasks])
                </div>
            </div>
        </div>
    </div>

    <!-- /.row -->
</div>
@endsection

