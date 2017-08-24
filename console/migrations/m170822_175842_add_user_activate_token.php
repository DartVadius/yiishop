<?php

use yii\db\Migration;

class m170822_175842_add_user_activate_token extends Migration {
//    public function safeUp()
//    {
//
//    }
//
//    public function safeDown()
//    {
//        echo "m170822_175842_add_user_activate_token cannot be reverted.\n";
//
//        return false;
//    }

    public function up() {
        $this->addColumn('{{%user}}', 'email_confirm_token', $this->string()->unique()->after('email'));
    }

    public function down() {
        $this->dropColumn('{{%user}}', 'email_confirm_token');
    }
}
