<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%path_files}}`.
 */
class m220414_135226_add_id_column_to_path_files_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%path_files}}', 'id', $this->primaryKey()->first());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m220414_135226_add_id_column_to_path_files_table.";

        return false;
    }
}
