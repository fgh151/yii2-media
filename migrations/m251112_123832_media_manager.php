<?php

namespace fgh151\media\migrations;

use yii\db\Migration;

class m251112_123832_media_manager extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%media_folder}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->defaultValue(null),
            'title' => $this->string()->notNull(),
        ]);

        $this->createTable('{{%media_file}}', [
            'id' => $this->primaryKey(),
            'media_folder_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'file' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%media_file}}');
        $this->dropTable('{{%media_folder}}');
    }
}
