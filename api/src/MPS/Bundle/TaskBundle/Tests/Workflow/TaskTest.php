<?php
namespace MPS\Bundle\TaskBundle\Tests\Workflow;

use MPS\Bundle\TaskBundle\Workflow;

/**
 * Class TaskTest
 * @package MPS\Bundle\TaskBundle\Tests\Entity
 */
class TaskTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var
     */
    protected $taskWorkflow;

    public function setUp()
    {
        $this->taskWorkflow = new Workflow\Task();
    }

    /**
     * @test
     */
    public function shouldThrowErrorOnInvalidNewStatus()
    {
        // setup
        $newStatus = 'FizzBuzz';
        $currentStatus = '';
        $expected = "'FIZZBUZZ' is not a valid status (NEW, INPROGRESS, COMPLETED)";

        // test
        try {
            $this->taskWorkflow->canChangeStatus($newStatus, $currentStatus);
        } catch (\Exception $e) {
            $actual = $e->getMessage();
        }

        // assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldCreateNewStatusInTask()
    {
        // setup
        $newStatus = 'new';
        $currentStatus = '';
        $expected = true;

        // test
        $actual = $this->taskWorkflow->canChangeStatus($newStatus, $currentStatus);

        // assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldAllowCurrentlyNewToInProgress()
    {
        // setup
        $newStatus = 'in progress';
        $currentStatus = 'new';
        $expected = true;

        // test
        $actual = $this->taskWorkflow->canChangeStatus($newStatus, $currentStatus);

        // assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldAllowCompletedToInProgress()
    {
        // setup
        $newStatus = 'in progress';
        $currentStatus = 'completed';
        $expected = true;

        // test
        $actual = $this->taskWorkflow->canChangeStatus($newStatus, $currentStatus);

        // assert
        $this->assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function shouldNotAllowEmptyNewStatus()
    {
        // setup
        $newStatus = '';
        $currentStatus = '';
        $expected = 'Status is empty';

        // test
        try {
            $this->taskWorkflow->canChangeStatus($newStatus, $currentStatus);
        } catch (\Exception $e) {
            $actual = $e->getMessage();
        }

        // assert
        $this->assertSame($expected, $actual);
    }
}