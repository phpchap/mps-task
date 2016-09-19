@if (count($tasks) > 0)
<ul>
    <?php foreach($tasks as $task) { ?>
        <li>
            <h2><?php echo $task['title']; ?></h2>
            <p><?php echo $task['description']; ?></p>
            <p>(<a href="{{ route('move_to_in_progress_task', ['id' => $task['id']]) }}">in progress</a> /
                <a href="{{ route('delete_task', ['id' => $task['id']]) }}">delete</a>)
            </p>
        </li>
    <?php } ?>
</ul>
@endif