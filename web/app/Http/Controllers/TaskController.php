<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Api\Client;
use Buzz\Browser;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function home()
    {
        $tasks = (new Client(new Browser))->getAllTasks();

        return view(
            'welcome', [
                'newTasks' => $tasks['new'],
                'inProgressTasks' => $tasks['inProgress'],
                'completedTasks' => $tasks['completed'],
            ]
        );
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function newTask($id)
    {
        $display = 'status';
        $message = 'Task moved to new!';

        try {
           (new Client(new Browser))->moveTaskToNewStatus($id);
        } catch (\Exception $e) {
            $message = 'Error: '.$e->getMessage();
            $display = 'status';
        }

        return redirect(route('tasks'))->with($display, $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function inProgressTask($id)
    {
        $display = 'status';
        $message = 'Task moved to in progress!';

        try {
            (new Client(new Browser))->moveTaskToInProgressStatus($id);
        } catch (\Exception $e) {
            $display = 'error';
            $message = 'Error: '.$e->getMessage();
        }

        return redirect(route('tasks'))->with($display, $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function completeTask($id)
    {
        $display = 'status';
        $message = 'Task moved to in progress!';

        try {
            (new Client(new Browser))->moveTaskToCompletedStatus($id);
        } catch (\Exception $e) {
            $display = 'error';
            $message = 'Error: '.$e->getMessage();
        }

        return redirect(route('tasks'))->with($display, $message);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteTask($id)
    {
        $display = 'status';
        $message = 'Task deleted!';

        try {
            (new Client(new Browser))->deleteTask($id);
        } catch (\Exception $e) {
            $display = 'error';
            $message = 'Error: '.$e->getMessage();
        }

        return redirect(route('tasks'))->with($display, $message);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required|max:255',
        ]);

        (new Client(new Browser))->newTask(
            $request->get('title'),
            $request->get('description')
        );

        return redirect(route('tasks'))->with('status', 'New Task added!');
    }
}