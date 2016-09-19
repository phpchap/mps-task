<?php
namespace MPS\Bundle\TaskBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use MPS\Bundle\TaskBundle\Entity\Task;

/**
 * Class LoadTaskData
 * @package MPS\Bundle\TaskBundle\DataFixtures\ORM
 */
class LoadTaskData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $task = new Task;
        $task->setTitle("first");
        $task->setStatus("new");
        $task->setDescription("reminder");
        $task->setCreatedAt(new \DateTime("2014-01-25T00:00:00+000"));
        $task->setUpdatedAt(new \DateTime("2014-02-25T00:00:00+000"));
        $manager->persist($task);

        $task = new Task;
        $task->setTitle("second");
        $task->setStatus("new");
        $task->setDescription("another reminder");
        $task->setCreatedAt(new \DateTime("2014-03-25T00:00:00+000"));
        $task->setUpdatedAt(new \DateTime("2014-04-25T00:00:00+000"));
        $manager->persist($task);

        $task = new Task;
        $task->setTitle("third");
        $task->setStatus("in progress");
        $task->setDescription("another reminder");
        $task->setCreatedAt(new \DateTime("2014-05-25T00:00:00+000"));
        $task->setUpdatedAt(new \DateTime("2014-06-25T00:00:00+000"));
        $manager->persist($task);

        $task = new Task;
        $task->setTitle("fourth");
        $task->setStatus("in progress");
        $task->setDescription("more reminders");
        $task->setCreatedAt(new \DateTime("2014-07-25T00:00:00+000"));
        $task->setUpdatedAt(new \DateTime("2014-08-25T00:00:00+000"));
        $manager->persist($task);

        $task = new Task;
        $task->setTitle("fifth");
        $task->setStatus("done");
        $task->setDescription("more reminders");
        $task->setCreatedAt(new \DateTime("2014-07-25T00:00:00+000"));
        $task->setUpdatedAt(new \DateTime("2014-08-25T00:00:00+000"));

        $manager->persist($task);
        $manager->flush();
    }
}