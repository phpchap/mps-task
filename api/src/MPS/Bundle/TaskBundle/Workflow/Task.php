<?php

namespace MPS\Bundle\TaskBundle\Workflow;

/**
 * Class Task
 * @package MPS\Bundle\TaskBundle\Workflow
 */
class Task {

    const TASK_NEW = 'NEW';
    const TASK_IN_PROGRESS = 'INPROGRESS';
    const TASK_COMPLETED = 'COMPLETED';

    /**
     * @param $newStatus
     * @param string $currentStatus
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function canChangeStatus($newStatus, $currentStatus='')
    {
        // validate
        $this->validateStatus($newStatus);

        // process current/new status changes..
        if (!empty($currentStatus)) {

            $this->validateStatus($currentStatus)
                ->checkNotSameStatusLevel($newStatus, $currentStatus)
                ->checkNotProgressedTooFar($newStatus, $currentStatus);

        }

        // we always want to allow new status..
        return true;
    }

    /**
     * @param $status
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function validateStatus($status)
    {
        if (empty($status)) {
            throw new \InvalidArgumentException("Status is empty");
        }

        $priority = $this->getTaskPriorityAr();

        // make sure the new status is valid
        if (!isset($priority[$this->formatStatus($status)])) {

            throw new \InvalidArgumentException(
                sprintf(
                    "'%s' is not a valid status (%s)",
                    $this->formatStatus($status),
                    implode(", ", array_keys($priority))
                )
            );
        }

        return $this;
    }

    /**
     * @param $status
     * @return mixed
     */
    protected function getStatusLevel($status)
    {
        $priority = $this->getTaskPriorityAr();
        return $priority[$this->formatStatus($status)];
    }

    /**
     * @param $status
     * @return string
     */
    protected function formatStatus($status)
    {
        return strtoupper(preg_replace("~[\W\s]~", "", $status));
    }

    /**
     * @param $newStatus
     * @param $currentStatus
     * @return $this
     * @throws \InvalidArgumentException
     */
    protected function checkNotSameStatusLevel($newStatus, $currentStatus)
    {
        $newStatusLevel = $this->getStatusLevel($newStatus);
        $currentStatusLevel = $this->getStatusLevel($currentStatus);

        if ($newStatusLevel == $currentStatusLevel) {
            throw new \InvalidArgumentException(
                sprintf(
                    "New status: '%s' is the same as current status: '%s'",
                    $this->formatStatus($newStatus),
                    $this->formatStatus($currentStatus),
                    implode(" => ", array_keys($this->getTaskPriorityAr()))
                )
            );
        }

        return $this;
    }

    /**
     * @param $newStatus
     * @param $currentStatus
     * @return $this
     * @throws \InvalidArgumentException
     */
    protected function checkNotProgressedTooFar($newStatus, $currentStatus)
    {
        $newStatusLevel = $this->getStatusLevel($newStatus);
        $currentStatusLevel = $this->getStatusLevel($currentStatus);

        if (($newStatusLevel + $currentStatusLevel) == 2) {
            throw new \InvalidArgumentException(
                sprintf(
                    "New status: '%s' and current status: '%s' does not follow workflow: %s",
                    $this->formatStatus($newStatus),
                    $this->formatStatus($currentStatus),
                    implode(" => ", array_keys($this->getTaskPriorityAr()))
                )
            );
        }

        return $this;
    }

    /**
     * @return array
     */
    protected function getTaskPriorityAr()
    {
        return [
            self::TASK_NEW => 0,
            self::TASK_IN_PROGRESS => 1,
            self::TASK_COMPLETED => 2
        ];
    }
}