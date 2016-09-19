<?php
namespace App\Api;

use Buzz\Browser;

/**
 * Class Client
 * @package App\Api
 */
class Client {

    /**
     * @var \Buzz\Browser
     */
    protected $browser;

    /**
     * @var array
     */
    protected $jsonHeader = ['Content-Type' => 'application/json'];

    /**
     * @var array
     */
    protected $responseAr = [];

    /**
     * @param Browser $browser
     */
    public function __construct(Browser $browser)
    {
        $this->browser = $browser;
    }

    /**
     * @param $id
     * @throws \RuntimeException
     */
    public function deleteTask($id)
    {
        $clientConfig = config('client');
        $url = sprintf(
            "%s%s%s",
            $clientConfig['api_url'],
            $clientConfig['delete_task_uri'],
            $id
        );

        $response = $this->browser->delete($url, $this->jsonHeader);

        if ($response->getStatusCode() != "204") {
            $this->handleError($response);
        }
    }

    /**
     * @param $id
     */
    public function moveTaskToNewStatus($id)
    {
        $this->changeTaskStatus($id, 'new');
    }

    /**
     * @param $id
     */
    public function moveTaskToInProgressStatus($id)
    {
        $this->changeTaskStatus($id, 'in progress');
    }

    /**
     * @param $id
     */
    public function moveTaskToCompletedStatus($id)
    {
        $this->changeTaskStatus($id, 'completed');
    }

    /**
     * @param $title
     * @param $description
     * @throws \RuntimeException
     */
    public function newTask($title, $description)
    {
        $clientConfig = config('client');
        $url = sprintf(
            "%s%s",
            $clientConfig['api_url'],
            $clientConfig['post_tasks_uri']
        );

        $now = new \DateTime();

        $jsonToSend = json_encode([
            'title' => $title,
            'description' => $description,
            'status' => 'new',
            'createdAt' => $now->format('Y-m-d H:i:s'),
            'updatedAt' => $now->format('Y-m-d H:i:s')
        ]);

        $response = $this->browser->post($url, ['Content-Type' => 'application/json'], $jsonToSend);

        if ($response->getStatusCode() != "201") {
            $this->handleError($response);
        }
    }

    /**
     * @return array
     */
    public function getAllTasks()
    {
        $newTasks = $this->getTasksByStatus('new');
        $inProgressTasks = $this->getTasksByStatus('in progress');
        $completedTasks = $this->getTasksByStatus('completed');

        return [
            'new' => $newTasks,
            'inProgress' => $inProgressTasks,
            'completed' => $completedTasks,
        ];
    }

    /**
     * @param string $page
     * @param string $limit
     * @return array
     * @throws \RuntimeException
     */
    public function getTasks($page='', $limit='')
    {
        $page = (!empty($page)) ? $page : '1';
        $limit = (!empty($limit)) ? $limit : '10';

        $clientConfig = config('client');
        $url = sprintf(
            "%s%s?page=%s&limit=%s",
            $clientConfig['api_url'],
            $clientConfig['get_tasks_uri'],
            $page,
            $limit
        );

        $response = $this->browser->get($url);

        if ($response->getStatusCode() != "200") {
            $this->handleError($response);
        }

        $this->responseAr = json_decode($response->getContent(), true);

        return (!empty($this->responseAr['_embedded']['items']) &&
            count($this->responseAr['_embedded']['items']) > 0) ?
            $this->responseAr['_embedded']['items'] :
            [];
    }

    /**
     * @param $status
     * @return array
     */
    protected function getTasksByStatus($status)
    {
        if (empty($this->responseAr)) {
            $this->getTasks();
        }

        $taskAr = [];

        if (count($this->responseAr['_embedded']['items']) > 0) {
            foreach($this->responseAr['_embedded']['items'] as $task) {
                if (!empty($task['status']) && $task['status'] == $status) {
                    $taskAr[] = $task;
                }
            }
        }

        return $taskAr;
    }

    /**
     * @param $id
     * @param $status
     * @throws \RuntimeException
     */
    protected function changeTaskStatus($id, $status)
    {
        $clientConfig = config('client');
        $url = sprintf(
            "%s%s%s",
            $clientConfig['api_url'],
            $clientConfig['patch_tasks_uri'],
            $id
        );

        $jsonToSend = json_encode([
            'status' => $status
        ]);

        $response = $this->browser->patch($url, ['Content-Type' => 'application/json'], $jsonToSend);

        if ($response->getStatusCode() != "204") {
            $this->handleError($response);
        }
    }

    /**
     * @param $response
     * @throws \RuntimeException
     */
    protected function handleError($response)
    {
        $errorAr = json_decode($response->getContent(), true);
        $message = !(empty($errorAr['error']['exception'][0]['message'])) ?
            $errorAr['error']['exception'][0]['message'] :
            'something really bad happened, please check the logs';

        throw new \RuntimeException(
            sprintf(
                'could not create task, status code: %s, error: %s',
                $response->getStatusCode(),
                $message
            )
        );
    }
}