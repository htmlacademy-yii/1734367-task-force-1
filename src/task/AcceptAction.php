<?php

namespace taskforce\task;

/**
 * Класс, реализующий действие - принятие задания
 */
class AcceptAction extends AbstractAction
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return TaskInterface::ACTIONS[TaskInterface::ACTION_ACCEPT];
    }

    /**
     * @inheritDoc
     */
    public function getActionName(): string
    {
        return TaskInterface::ACTION_ACCEPT;
    }

    /**
     * @inheritDoc
     */
    public static function checkAccess(int $performerId, int $customerId, int $userId): bool
    {
        return $performerId === $userId;
    }
}
