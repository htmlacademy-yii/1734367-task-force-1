<?php

use yii\db\Migration;

/**
 * Class m220322_062345_edit_password_hash_column_to_users_table
 */
class m220322_062345_edit_password_hash_column_to_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->renameColumn('{{%users}}', 'password_hash', 'password');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->renameColumn('{{%users}}', 'password', 'password_hash');
    }
}
