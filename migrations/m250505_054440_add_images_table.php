<?php

use yii\db\Migration;
use yii\db\Schema;

class m250505_054440_add_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public $tableName = '{{%gallery}}';
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            array(
                'id' => Schema::TYPE_PK,
                'img_path' => $this->string(255)->notNull(),
                'img_extension' => $this->string(8)->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->datetime()->notNull()->defaultValue(new \yii\db\Expression("NOW()"))
            )
        );
        $this->createIndex('idx-gallery-created_by', 'gallery', 'created_by');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropIndex('idx-gallery-created_by', 'gallery');
        $this->dropTable($this->tableName);        
    }
}
