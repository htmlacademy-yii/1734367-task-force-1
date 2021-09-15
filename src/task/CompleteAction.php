<?php

namespace taskforce\task;

class CompleteAction extends AbstractAction
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return TaskInterface::ACTIONS[TaskInterface::ACTION_COMPLETE];
    }

    /**
     * @inheritDoc
     */
    public function getActionName(): string
    {
        return TaskInterface::ACTION_COMPLETE6;
    }

    /**
     * @inheritDoc
     */
    public static function checkAccess(int $performerId, int $customerId, int $userId): bool
    {
        return $customerId === $userId;
    }
}
