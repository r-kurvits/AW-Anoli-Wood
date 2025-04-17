<?php

use yii\db\Migration;
use yii\db\Schema;

class m250411_180641_categories_table extends Migration
{
    /**
     * {@inheritdoc}
     */

    public $tableName = '{{%categories}}';
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            array(
                'id' => Schema::TYPE_PK,
                'name' => $this->string(255)->notNull(),
                'position' => $this->integer()->notNull(),
                'img_path' => $this->string(255)->defaultValue(""),
                'img_extension' => $this->string(8)->defaultValue(""),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->datetime()->notNull()->defaultValue(new \yii\db\Expression("NOW()"))
            )
        );

        $this->createIndex('idx-categories-created_by', 'categories', 'created_by');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-categories-created_by', 'categories');
        $this->dropTable($this->tableName);
    }
}
