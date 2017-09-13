<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_value`.
 */
class m170910_175634_create_shop_value_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_value}}', [
            'product_id' => $this->integer()->notNull(),
            'characteristic_id' => $this->integer()->notNull(),
            'value' => $this->string(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-shop_value}}', '{{%shop_value}}', ['product_id', 'characteristic_id']);

        $this->createIndex('{{%idx-shop_value-product_id}}', '{{%shop_value}}', 'product_id');
        $this->createIndex('{{%idx-shop_value-characteristic_id}}', '{{%shop_value}}', 'characteristic_id');

        $this->addForeignKey('{{%fk-shop_value-product_id}}', '{{%shop_value}}', 'product_id', '{{%shop_product}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shop_value-characteristic_id}}', '{{%shop_value}}', 'characteristic_id', '{{%product_characteristic}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%shop_value}}');
    }
}
