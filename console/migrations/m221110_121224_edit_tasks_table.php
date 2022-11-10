<?php

use yii\db\Migration;

/**
 * Class m221110_121224_edit_tasks_table
 */
class m221110_121224_edit_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%tasks}}', 'location', $this->string(255)->comment('Локация выполнения задания')->after('city_id'));
        $this->addColumn('{{%tasks}}', 'geo_location', $this->string(255)->comment('Geo локации выполнения задания')->after('location'));
        $this->dropColumn('{{%tasks}}', 'geo_latitude');
        $this->dropColumn('{{%tasks}}', 'geo_longitude');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%tasks}}', 'location');
        $this->dropColumn('{{%tasks}}', 'geo_location');
        $this->addColumn('{{%tasks}}', 'geo_latitude', $this->float()->after('city_id'));
        $this->addColumn('{{%tasks}}', 'geo_longitude', $this->float()->after('geo_latitude'));
    }
}
