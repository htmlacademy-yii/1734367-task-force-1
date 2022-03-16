<?php

namespace frontend\models;

use yii\db\ActiveRecord;

class BaseModel extends ActiveRecord
{
    /** @var string */
    public string $titlePage = 'TaskForce';

    /**
     * @param string $titlePage
     */
    public function setTitlePage(string $titlePage): void
    {
        $this->titlePage = $titlePage;
    }

    /**
     * @return string
     */
    public function getTitlePage(): string
    {
        return $this->titlePage;
    }

}