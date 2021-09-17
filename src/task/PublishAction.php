<?php

namespace taskforce\task;

class PublishAction extends AbstractAction
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return TaskInterface::ACTIONS[TaskInterface::ACTION_PUBLISH];
    }

    /**
     * @inheritDoc
     */
    public function getActionName(): string
    {
        return TaskInterface::ACTION_PUBLISH;
    }

    /**
     * @inheritDoc
     */
    public static function checkAccess(int $performerId, int $customerId, int $userId): bool
    {
        return $customerId === $userId;
    }
}
