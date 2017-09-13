<?php

use yii\db\Migration;

/**
 * Handles the creation of table `shop_tag_assignment`.
 */
class m170912_135738_create_shop_tag_assignment_table extends Migration {
    /**
     * @inheritdoc
     */
    public function up() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%shop_tag_assignment}}', [
            'product_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addPrimaryKey('{{%pk-shop_tag_assignment}}', '{{%shop_tag_assignment}}', ['product_id', 'tag_id']);

        $this->createIndex('{{%idx-shop_tag_assignment-product_id}}', '{{%shop_tag_assignment}}', 'product_id');
        $this->createIndex('{{%idx-shop_tag_assignment-tag_id}}', '{{%shop_tag_assignment}}', 'tag_id');

        $this->addForeignKey('{{%fk-shop_tag_assignment-product_id}}', '{{%shop_tag_assignment}}', 'product_id', '{{%shop_product}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-shop_tag_assignment-tag_id}}', '{{%shop_tag_assignment}}', 'tag_id', '{{%shop_tag}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down() {
        $this->dropTable('{{%shop_tag_assignment}}');
    }
}
