<?php

namespace taskforce\services;

/**
 * Класс для работы с заданием
 *
 * @version 1.0, 20.04.2021
 */
class Task implements TaskInterface
{
	/** @var int Идентификатор исполнителя */
	private $performerId;
	/** @var int Идентификатор заказчика */
	private $customerId;

	/**
	 * Конструктор класса
	 *
	 * @version 1.0, 20.04.2021
	 *
	 * @param int $performerId Идентификатор исполнителя
	 * @param int $customerId Идентификатор заказчика
	 * @return void
	 */
	public function __construct(int $performerId, int $customerId)
	{
		$this->performerId = $performerId;
		$this->customerId = $customerId;
	}

	/**
	 * Возвращает статус задания
	 *
	 * @version 1.0, 20.04.2021
	 *
	 * @param string $action Действие, выполненное над заданием
	 * @return string
	 */
	public function getStatus(string $action): string
	{
		if (!array_key_exists($action,self::ACTIONS_TASK)) {
			return '';
		}

		switch ($action) {
			case self::TASK_PUBLISHED:
				$statusTask = self::STATUS_NEW;
				break;
			case self::TASK_CANCELED:
				$statusTask = self::STATUS_CANCELED;
				break;
			case self::TASK_COMPLETED:
				$statusTask = self::STATUS_DONE;
				break;
			case self::TASK_ACCEPTED:
				$statusTask = self::STATUS_ACTIVE;
				break;
			case self::TASK_FAILURE:
				$statusTask = self::STATUS_FAILED;
				break;
			default:
				$statusTask = '';
				break;
		}

		return $statusTask ? self::STATUSES_TASK[$statusTask] : $statusTask;
	}

	/**
	 * Возвращает доступные действия для задания
	 *
	 * @version 1.0, 20.04.2021
	 *
	 * @param string $status Актуальный статус задания
	 * @return array
	 */
	public function getAction(string $status = ''): array
	{
		switch ($status) {
			case self::STATUS_NEW:
				$performerActionTask = self::TASK_ACCEPTED; // исполнитель
				$customerActionTask = self::TASK_CANCELED; // заказчик
				break;
			case self::STATUS_ACTIVE:
				$performerActionTask = self::TASK_FAILURE; // исполнитель
				$customerActionTask = self::TASK_COMPLETED; // заказчик
				break;
			default:
				$performerActionTask = ''; // исполнитель
				$customerActionTask = self::TASK_PUBLISHED; // заказчик
				break;
		}

		return [
			'performer' => $performerActionTask ? self::ACTIONS_TASK[$performerActionTask] : '', // исполнитель
			'customer' => self::ACTIONS_TASK[$customerActionTask], // заказчик
		];
	}

	/**
	 * Возвращает карту статусов задания
	 *
	 * @author Kirill Markin
	 * @version 1.0, 26.04.2021
	 *
	 * @return array
	 */
	public static function getStatusesMap(): array
	{
		return self::STATUSES_TASK;
	}

	/**
	 * Возвращает карту действий задания
	 *
	 * @author Kirill Markin
	 * @version 1.0, 26.04.2021
	 *
	 * @return array
	 */
	public static function getActionsMap(): array
	{
		return self::ACTIONS_TASK;
	}
}