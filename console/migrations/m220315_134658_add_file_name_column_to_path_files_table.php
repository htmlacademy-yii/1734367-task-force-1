<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%path_files}}`.
 */
class m220315_134658_add_file_name_column_to_path_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%path_files}}', 'file_name', $this->string(100)->after('path'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%path_files}}', 'file_name');
    }
}
