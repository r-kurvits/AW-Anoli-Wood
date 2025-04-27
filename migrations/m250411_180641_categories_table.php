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

        $this->insert($this->tableName, [
            'name' => 'Saematerjal',
            'position' => 1,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);

        $this->insert($this->tableName, [
            'name' => 'Höövelmaterjal',
            'position' => 2,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);

        $this->insert($this->tableName, [
            'name' => 'Sisevoodrilaud',
            'position' => 3,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);

        $this->insert($this->tableName, [
            'name' => 'Välisvoodrilaud',
            'position' => 4,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);

        $this->insert($this->tableName, [
            'name' => 'Terassilaud',
            'position' => 5,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);

        $this->insert($this->tableName, [
            'name' => 'Immutatud puit',
            'position' => 6,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);

        $this->insert($this->tableName, [
            'name' => 'Termotöödeldud puit',
            'position' => 7,
            'img_path' => "",
            'img_extension' => "",
            'created_by' => 1,
        ]);
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
