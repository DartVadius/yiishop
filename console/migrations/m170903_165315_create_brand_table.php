<?php

use yii\db\Migration;

/**
 * Handles the creation of table `brand`.
 */
class m170903_165315_create_brand_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable('{{%brand}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'meta_json' => 'JSON NOT NULL',
        ], $tableOptions);

        $this->createIndex('{{%idx-brand-slug}}', '{{%brand}}', 'slug', true);
    }

    public function down()
    {
        $this->dropTable('{{%brand}}');
    }
}
