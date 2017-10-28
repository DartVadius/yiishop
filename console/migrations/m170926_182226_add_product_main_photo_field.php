<?php

use yii\db\Migration;

class m170926_182226_add_product_main_photo_field extends Migration {
    public function up() {
        $this->addColumn('{{%shop_product}}', 'main_photo_id', $this->integer());

        $this->createIndex('{{%idx-shop_product-main_photo_id}}', '{{%shop_product}}', 'main_photo_id');

        $this->addForeignKey('{{%fk-shop_product-main_photo_id}}', '{{%shop_product}}', 'main_photo_id', '{{%shop_photos}}', 'id', 'SET NULL', 'RESTRICT');
    }

    public function down() {
        $this->dropForeignKey('{{%fk-shop_product-main_photo_id}}', '{{%shop_product}}');

        $this->dropColumn('{{%shop_product}}', 'main_photo_id');
    }
}
