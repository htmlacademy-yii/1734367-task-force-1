<?php

use yii\db\Migration;

/**
 * Class m220316_090808_edit_response_table
 */
class m220316_090808_edit_response_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%responses}}', 'performer_comment', $this->string(255)->after('value'));

        $this->renameColumn('{{%responses}}', 'value', 'performer_cost');



    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%responses}}', 'performer_comment');

        $this->renameColumn('{{%responses}}', 'performer_cost', 'value');
    }
}
