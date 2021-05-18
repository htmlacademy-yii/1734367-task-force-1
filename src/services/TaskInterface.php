<?php

namespace taskforce\services;

/**
 * Интерфейс задания
 *
 * @version 1.0, 13.04.2021
 */
interface TaskInterface
{
	/** Статус задания: новое (заказчик) */
	const STATUS_NEW = 'new';
	/** Статус задания: отменено (заказчик) */
	const STATUS_CANCELED = 'canceled';
	/** Статус задания: выполнено (заказчик) */
	const STATUS_DONE = 'done';
	/** Статус задания: в работе (исполнитель) */
	const STATUS_ACTIVE = 'active';
	/** Статус задания: провалено (исполнитель) */
	const STATUS_FAILED = 'failed';

	/** Действие: публикация задания (заказчик) */
	const TASK_PUBLISHED = 'taskPublished';
	/** Действие: отмена задания (заказчик) */
	const TASK_CANCELED = 'taskCanceled';
	/** Действие: завершение задания (заказчик) */
	const TASK_COMPLETED = 'taskCompleted';
	/** Действие: принятие задания (исполнитель) */
	const TASK_ACCEPTED = 'taskAccepted';
	/** Действие: отказ от задания (исполнитель) */
	const TASK_FAILURE = 'taskFailure';

	/** Массив соответствия статусов задания и их наименований */
	const STATUSES_TASK = [
		self::STATUS_NEW => 'Новое',
		self::STATUS_CANCELED => 'Отменено',
		self::STATUS_DONE => 'Выполнено',
		self::STATUS_ACTIVE => 'В работе',
		self::STATUS_FAILED => 'Провалено',
	];

	/** Массив соответствия действий задания и их наименований */
	const ACTIONS_TASK = [
		self::TASK_PUBLISHED => 'Публикация задания',
		self::TASK_CANCELED => 'Отмена задания',
		self::TASK_COMPLETED => 'Завершение задания',
		self::TASK_ACCEPTED => 'Принятие задания',
		self::TASK_FAILURE => 'Отказ от задания',
	];

	/**
	 * Конструктор интерфейса
	 *
	 * @version 1.0, 13.04.2021
	 *
	 * @param int $performerId Идентификатор исполнителя
	 * @param int $customerId Идентификатор заказчика
	 * @return void
	 */
	public function __construct(int $performerId, int $customerId);

	/**
	 * Возвращает статус задания
	 *
	 * @version 1.0, 13.04.2021
	 *
	 * @param string $action Действие, выполненное над заданием
	 * @return string
	 */
	public function getStatus(string $action): string;

	/**
	 * Возвращает доступные действия для задания
	 *
	 * @version 1.0, 13.04.2021
	 *
	 * @param string $status Актуальный статус задания
	 * @return array
	 */
	public function getAction(string $status): array;

	/**
	 * Возвращает карту статусов задания
	 *
	 * @author Kirill Markin
	 * @version 1.0, 26.04.2021
	 *
	 * @return array
	 */
	public static function getStatusesMap(): array;

	/**
	 * Возвращает карту действий задания
	 *
	 * @author Kirill Markin
	 * @version 1.0, 26.04.2021
	 *
	 * @return array
	 */
	public static function getActionsMap(): array;
}
