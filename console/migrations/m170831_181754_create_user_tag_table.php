<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user_tag`.
 */
class m170831_181754_create_user_tag_table extends Migration {
    /**
     * @inheritdoc
     */
    public function up() {
        $tableOptions = 'CHARACTER SET utf8 collate utf8_general_ci ENGINE=InnoDB';
        $this->createTable('shop_tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropTable('shop_tag');
    }
}
