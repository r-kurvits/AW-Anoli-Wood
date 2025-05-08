<?php

use yii\db\Migration;
use yii\db\Schema;

class m250426_165954_add_product_lines_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public $tableName = '{{%product_lines}}';
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            array(
                'id' => Schema::TYPE_PK,
                'product_id' => $this->integer()->notNull(),
                'width' => $this->string(255)->notNull(),
                'length' => $this->string(255)->notNull(),
                'thickness' => $this->string(255)->notNull(),
                'wood_type' => $this->string(255)->notNull(),
                'price' => $this->float()->notNull(),
                'price_type' => $this->string(32)->notNull(),
                'img_path' => $this->string(255)->defaultValue(""),
                'img_extension' => $this->string(8)->defaultValue(""),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->datetime()->notNull()->defaultValue(new \yii\db\Expression("NOW()"))
            )
        );

        $this->createIndex('idx-product_lines-created_by', 'product_lines', 'created_by');
        $this->createIndex('idx-product_lines-product_id', 'product_lines', 'product_id');

        $this->addForeignKey(
            'fk-product_lines-product_id',
            'product_lines',
            'product_id',
            'products',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk-product_lines-product_id", "product_lines");
        $this->dropIndex('idx-product_lines-created_by', 'product_lines');
        $this->dropIndex('idx-product_lines-product_id', 'product_lines');

        $this->dropTable($this->tableName);
    }
}
