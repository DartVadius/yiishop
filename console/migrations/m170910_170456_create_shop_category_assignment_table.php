<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_category_assignment`.
 */
class m170910_170456_create_shop_category_assignment_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_category_assignment}}', [
            'product_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-shop_category_assignment}}', '{{%shop_category_assignment}}', ['product_id', 'category_id']);

        $this->createIndex('{{%idx-shop_category_assignment-product_id}}', '{{%shop_category_assignment}}', 'product_id');
        $this->createIndex('{{%idx-shop_category_assignment-category_id}}', '{{%shop_category_assignment}}', 'category_id');

        $this->addForeignKey('{{%fk-shop_category_assignment-product_id}}', '{{%shop_category_assignment}}', 'product_id', '{{%shop_product}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shop_category_assignment-category_id}}', '{{%shop_category_assignment}}', 'category_id', '{{%product_category}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%shop_category_assignment}}');
    }
}
