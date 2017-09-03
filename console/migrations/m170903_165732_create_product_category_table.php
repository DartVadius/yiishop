<?php

use yii\db\Migration;

/**
 * Handles the creation of table `product_category`.
 */
class m170903_165732_create_product_category_table extends Migration {
    public function up() {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%product_category}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'title' => $this->string(),
            'description' => $this->text(),
            'meta_json' => 'JSON',
            'lft' => $this->integer()->notNull(),
            'rgt' => $this->integer()->notNull(),
            'depth' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('{{%idx-product_category-slug}}', '{{%product_category}}', 'slug', true);

        $this->insert('{{%product_category}}', [
            'id' => 1,
            'name' => 'root',
            'slug' => 'root',
            'title' => null,
            'description' => null,
            'meta_json' => '{}',
            'lft' => 1,
            'rgt' => 2,
            'depth' => 0,
        ]);
    }

    public function down() {
        $this->dropTable('{{%product_category}}');
    }
}
