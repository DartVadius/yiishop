<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_network`.
 */
class m170826_121315_create_user_network_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 collate utf8_general_ci ENGINE=InnoDB';
        $this->createTable('{{%user_networks}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'identity' => $this->string()->notNull(),
            'network' => $this->string(25)->notNull(),
        ], $tableOptions);
        $this->createIndex('{{%idx-user_networks-identity-name}}', '{{%user_networks}}', ['identity', 'network'], true);
        $this->createIndex('{{%idx-user_networks-user_id}}', '{{%user_networks}}', 'user_id');
        $this->addForeignKey('{{%fk-user_networks-user_id}}', '{{%user_networks}}', 'user_id', '{{%user}}', 'id', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user_networks');
    }
}
