<?php

namespace taskforce\task;

class FailureAction extends AbstractAction
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return TaskInterface::ACTIONS[TaskInterface::ACTION_FAILURE];
    }

    /**
     * @inheritDoc
     */
    public function getActionName(): string
    {
        return TaskInterface::ACTION_FAILURE;
    }

    /**
     * @inheritDoc
     */
    public static function checkAccess(int $performerId, int $customerId, int $userId): bool
    {
        return $performerId === $userId;
    }
}
