<?php
return [
    'api_url' => env('API_URL', 'http://mpsapi.anotherwebdeveloper.com'),
    'get_tasks_uri' => env('GET_TASK_URI', '/tasks/'),
    'post_tasks_uri' => env('POST_TASK_URI', '/tasks/'),
    'patch_tasks_uri' => env('PATCH_TASK_URI', '/tasks/'),
    'delete_task_uri' => env('DELETE_TASK_URI', '/tasks/'),
];