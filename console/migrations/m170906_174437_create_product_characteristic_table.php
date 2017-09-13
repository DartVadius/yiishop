<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_characteristic`.
 */
class m170906_174437_create_product_characteristic_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_characteristic}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'type' => $this->string(16)->notNull(),
            'required' => $this->boolean()->notNull(),
            'default' => $this->string(),
            'variants_json' => 'JSON NOT NULL',
            'sort' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%product_characteristic}}');
    }
}
