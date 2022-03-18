<?php

use yii\db\Migration;

/**
 * Class m220318_102508_edit_users_table
 */
class m220318_102508_edit_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(
            '{{%users}}',
            'status',
            $this->tinyInteger(50)->unsigned()->notNull()->defaultValue(1)->after('city_id')
        );

        $this->renameColumn('{{%users}}', 'password', 'password_hash');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%users}}', 'status');

        $this->renameColumn('{{%users}}', 'password_hash', 'password');
    }
}
