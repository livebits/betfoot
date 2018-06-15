<?php

use yii\db\Migration;

/**
 * Handles the creation of table `prediction`.
 */
class m180615_215529_create_prediction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('prediction', [
            'id' => 'pk',
            'user_id' => 'int',

            'selected_team_id' => $this->integer(),
            'fixture_id' => $this->integer(),

            'user_price' => $this->integer(),
            'win_price' => $this->integer(),

            'status' => $this->string(),

            'updated_at' => 'int',
            'created_at' => 'int',
        ], $tableOptions);


        $this->addForeignKey('fk_prediction_user_id', 'prediction', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk_prediction_user_id', 'prediction');

        $this->dropTable('prediction');
    }
}
