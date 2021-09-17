<?php

namespace taskforce\task;

use stdClass;

/**
 * Класс для работы с заданием
 */
class Task implements TaskInterface
{
	/** @var int Идентификатор исполнителя */
	private $performerId;
	/** @var int Идентификатор заказчика */
	private $customerId;
    /** @var int Идентификатор текущего пользователя */
    public $userId;

	/**
	 * Конструктор класса
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
	 * @param string $action Действие, выполненное над заданием
	 * @return string
	 */
	public function getStatus(string $action): string
	{
		if (!array_key_exists($action,self::ACTIONS)) {
			return '';
		}

		switch ($action) {
			case self::ACTION_PUBLISH:
				$statusTask = self::STATUS_NEW;
				break;
			case self::ACTION_CANCEL:
				$statusTask = self::STATUS_CANCEL;
				break;
			case self::ACTION_COMPLETE:
				$statusTask = self::STATUS_DONE;
				break;
			case self::ACTION_ACCEPT:
				$statusTask = self::STATUS_ACTIVE;
				break;
			case self::ACTION_FAILURE:
				$statusTask = self::STATUS_FAIL;
				break;
			default:
				$statusTask = '';
				break;
		}

		return $statusTask ? self::STATUSES[$statusTask] : $statusTask;
	}

	/**
	 * Возвращает объект класса действия для задания
	 *
	 * @param string $status Актуальный статус задания
	 * @return object
	 */
	public function getAction(string $status = '')
	{
        $userId = $this->getUserId();
        $className = stdClass::class;

		switch ($status) {
			case self::STATUS_NEW:
                if (AcceptAction::checkAccess($this->performerId, $this->customerId, $userId)) {
                    $className = AcceptAction::class;
                }
                if (CancelAction::checkAccess($this->performerId, $this->customerId, $userId)) {
                    $className = CancelAction::class;
                }
                break;
            case self::STATUS_ACTIVE:
                if (FailureAction::checkAccess($this->performerId, $this->customerId, $userId)) {
                    $className = FailureAction::class;
                }
                if (CompleteAction::checkAccess($this->performerId, $this->customerId, $userId)) {
                    $className = CompleteAction::class;
                }
                break;
			default:
                if (PublishAction::checkAccess($this->performerId, $this->customerId, $userId)) {
                    $className = PublishAction::class;
                }
                break;
		}

       return new $className();
	}

	/**
	 * Возвращает карту статусов задания
	 *
	 * @return array
	 */
	public static function getStatusesMap(): array
	{
		return self::STATUSES;
	}

	/**
	 * Возвращает карту действий задания
	 *
	 * @return array
	 */
	public static function getActionsMap(): array
	{
		return self::ACTIONS;
	}

    /**
     * Устанавливает идентификатор текущего пользователя
     *
     * @param int $userId Идентификатор текущего пользователя
     * @return void
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Возвращает идентификатор текущего пользователя
     *
     * @return int
     */
    public function getUserId(): int
    {
        return (int) $this->userId;
    }
}
