<?php

namespace taskforce\task;

/**
 * Абстрактный класс, реализующий действие на заданием
 */
abstract class AbstractAction
{
    /**
     * Возвращает название действия
     *
     * @return string
     */
    abstract public function getName(): string;

    /**
     * Возвращает внутреннее название действия
     *
     * @return string
     */
    abstract public function getActionName(): string;

    /**
     * Метод проверка прав
     *
     * @param int $performerId Идентификатор исполнителя задания
     * @param int $customerId Идентификатор заказчика задания
     * @param int $userId Идентификатор текущего пользователя
     * @return bool
     */
    abstract public static function checkAccess(int $performerId, int $customerId, int $userId): bool;
}
