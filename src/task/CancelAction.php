<?php

namespace taskforce\task;

/**
 * Класс, реализующий действие - отмена задания
 */
class CancelAction extends AbstractAction
{
    /**
     * @inheritDoc
     */
    public function getName(): string
    {
        return TaskInterface::ACTIONS[TaskInterface::ACTION_CANCEL];
    }

    /**
     * @inheritDoc
     */
    public function getActionName(): string
    {
        return TaskInterface::ACTION_CANCEL;
    }

    /**
     * @inheritDoc
     */
    public static function checkAccess(int $performerId, int $customerId, int $userId): bool
    {
        return $customerId === $userId;
    }
}
