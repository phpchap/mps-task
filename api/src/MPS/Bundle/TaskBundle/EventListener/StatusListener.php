<?php
namespace MPS\Bundle\TaskBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use MPS\Bundle\TaskBundle\Entity\Task;

/**
 * Class StatusListener
 * @package MPS\Bundle\TaslBundle\EventListener
 */
class StatusListener
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Task) {
            return;
        }

        if (ctype_digit($entity->getId())) {

        }
        //$entityManager = $args->getEntityManager();
        // ... do something with the Product
        //var_dump($entity->getId());
    }
}