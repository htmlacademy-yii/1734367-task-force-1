<?php

namespace taskforce\task;

/**
 * Интерфейс задания
 */
interface TaskInterface
{
	/** Статус задания: новое (заказчик) */
	const STATUS_NEW = 'STATUS_NEW';
	/** Статус задания: отменено (заказчик) */
	const STATUS_CANCEL = 'STATUS_CANCEL';
	/** Статус задания: выполнено (заказчик) */
	const STATUS_DONE = 'STATUS_DONE';
	/** Статус задания: в работе (исполнитель) */
	const STATUS_ACTIVE = 'STATUS_ACTIVE';
	/** Статус задания: провалено (исполнитель) */
	const STATUS_FAIL = 'STATUS_FAIL';

	/** Действие: публикация задания (заказчик) */
	const ACTION_PUBLISH = 'ACTION_PUBLISH';
	/** Действие: отмена задания (заказчик) */
	const ACTION_CANCEL = 'ACTION_CANCEL';
	/** Действие: завершение задания (заказчик) */
	const ACTION_COMPLETE = 'ACTION_COMPLETE';
	/** Действие: принятие задания (исполнитель) */
	const ACTION_ACCEPT = 'ACTION_ACCEPT';
	/** Действие: отказ от задания (исполнитель) */
	const ACTION_FAILURE = 'ACTION_FAILURE';

	/** Массив соответствия статусов задания и их наименований */
	const STATUSES = [
		self::STATUS_NEW => 'Новое',
		self::STATUS_CANCEL => 'Отменено',
		self::STATUS_DONE => 'Выполнено',
		self::STATUS_ACTIVE => 'В работе',
		self::STATUS_FAIL => 'Провалено',
	];

	/** Массив соответствия действий задания и их наименований */
	const ACTIONS = [
		self::ACTION_PUBLISH => 'Публикация задания',
		self::ACTION_CANCEL => 'Отмена задания',
		self::ACTION_COMPLETE => 'Завершение задания',
		self::ACTION_ACCEPT => 'Принятие задания',
		self::ACTION_FAILURE => 'Отказ от задания',
	];

	/**
	 * Конструктор интерфейса
	 *
	 * @param int $performerId Идентификатор исполнителя
	 * @param int $customerId Идентификатор заказчика
	 * @return void
	 */
	public function __construct(int $performerId, int $customerId);

	/**
	 * Возвращает статус задания
	 *
	 * @param string $action Действие, выполненное над заданием
	 * @return string
	 */
	public function getStatus(string $action): string;

	/**
	 * Возвращает доступные действия для задания
	 *
	 * @param string $status Актуальный статус задания
	 * @return object
	 */
	public function getAction(string $status = '');

	/**
	 * Возвращает карту статусов задания
	 *
	 * @return array
	 */
	public static function getStatusesMap(): array;

	/**
	 * Возвращает карту действий задания
	 *
	 * @return array
	 */
	public static function getActionsMap(): array;
}
