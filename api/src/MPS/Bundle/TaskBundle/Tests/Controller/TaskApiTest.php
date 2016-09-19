<?php
namespace MPS\Bundle\TaskBundle\Tests\Controller;

use Lakion\ApiTestCase\JsonApiTestCase;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TaskApiTest
 * @package AppBundle\Tests\Controller
 */
class TaskApiTest extends JsonApiTestCase
{
    /**
     * @test
     */
    public function shouldCreateATask()
    {
        // setup
        // test
        $this->client = $this->createNewTask();

        // assert
        $response = $this->client->getResponse();
        $this->assertResponse($response, 'tasks/create_task_response', Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function shouldCreateAndGetATask()
    {
        // setup
        $this->client = $this->createNewTask();

        // test
        $this->client->request('GET', '/tasks/', [], [], ['CONTENT_TYPE' => 'application/json']);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        // assert
        $this->assertSame(1, count($response['_embedded']['items']));
        $this->assertSame('Read Email', $response['_embedded']['items'][0]['title']);
    }

    /**
     * @test
     */
    public function shouldCreateAndUpdateATask()
    {
        // setup
        $this->client = $this->createNewTask();
        $this->client->request('GET', '/tasks/', [], [], ['CONTENT_TYPE' => 'application/json']);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $taskId = $response['_embedded']['items'][0]['id'];
        $status = 'in progress';

        // test
        $this->client = $this->updateExistingTask($status, $taskId);

        // assert
        $this->assertSame(204, $this->client->getResponse()->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldCreateAndDeleteATask()
    {
        // setup
        $this->client = $this->createNewTask();
        $this->client->request('GET', '/tasks/', [], [], ['CONTENT_TYPE' => 'application/json']);
        $response = json_decode($this->client->getResponse()->getContent(), true);
        $taskId = $response['_embedded']['items'][0]['id'];

        // test
        $this->client = $this->deleteTask($taskId);
        $this->client->request('GET', '/tasks/', [], [], ['CONTENT_TYPE' => 'application/json']);
        $response = json_decode($this->client->getResponse()->getContent(), true);

        // assert
        $this->assertSame(0, $response['total']);
    }

    /**
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createNewTask()
    {
        // setup
        $data = json_encode([
            'title' => 'Read Email',
            'status' => 'new',
            'description' => 'Make sure that i always read my emails',
            'createdAt' => '2014-01-25T00:00:00+000',
            'updatedAt' => '2014-01-25T00:00:00+000'
        ]);

        // test
        $this->client->request('POST', '/tasks/', [], [], ['CONTENT_TYPE' => 'application/json'], $data);
        return $this->client;
    }

    /**
     * @param $status
     * @param $taskId
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function updateExistingTask($status, $taskId)
    {
        $data = json_encode([
            'status' => $status,
        ]);

        $this->client->request('PATCH', '/tasks/'.$taskId, [], [], ['CONTENT_TYPE' => 'application/json'], $data);
        return $this->client;
    }

    /**
     * @param $taskId
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function deleteTask($taskId)
    {
        $this->client->request('DELETE', '/tasks/'.$taskId, [], [], ['CONTENT_TYPE' => 'application/json']);
        return $this->client;
    }
}