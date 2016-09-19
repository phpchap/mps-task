<?php
namespace MPS\Bundle\TaskBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use MPS\Bundle\TaskBundle\Entity;
use MPS\Bundle\TaskBundle\Workflow;

/**
 * Class StatusListenerSubscriber
 * @package AppBundle\EventListener
 */
class StatusListenerSubscriber implements EventSubscriber
{
    /**
     * @return array
     */
    public function getSubscribedEvents()
    {
        return array(
            'preUpdate',
        );
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function preUpdate(LifecycleEventArgs $args)
    {
        return $this->checkCanUpdateStatus($args);
    }

    /**
     * @param LifecycleEventArgs $args
     */
    public function checkCanUpdateStatus(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $taskStatusWorkflow = new Workflow\Task;
        $newStatus = $entity->getStatus();

        if ($entity instanceof Entity\Task && $entity->getId()) {

            $entityManager = $args->getEntityManager();
            $existingStatus = $this->getTaskStatusFromDatabase($entity->getId(), $entityManager);
            $taskStatusWorkflow->canChangeStatus($newStatus, $existingStatus);

            return;
        }

        $taskStatusWorkflow->canChangeStatus($newStatus);
    }

    /**
     * @param $id
     * @param $em
     * @return mixed
     * @throws \Exception
     */
    protected function getTaskStatusFromDatabase($id, $em)
    {
        $sql = "SELECT status FROM Task WHERE id = :id";
        $params['id'] = $id;
        $stmt = $em->getConnection()->prepare($sql);
        $stmt->execute($params);
        $res = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($res[0]['status'])) {
            throw new \Exception("Could not find status for task ID: ".$id);
        }

        return $res[0]['status'];
    }
}

