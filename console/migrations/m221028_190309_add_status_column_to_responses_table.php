<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%responses}}`.
 */
class m221028_190309_add_status_column_to_responses_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%responses}}', 'status', $this->integer(10)->notNull()->defaultValue(0)->after('performer_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%responses}}', 'status');
    }
}
