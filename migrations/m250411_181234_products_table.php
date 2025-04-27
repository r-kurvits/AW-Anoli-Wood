<?php

use yii\db\Migration;
use yii\db\Schema;

class m250411_181234_products_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public $tableName = '{{%products}}';
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            array(
                'id' => Schema::TYPE_PK,
                'category_id' => $this->integer()->notNull(),
                'name' => $this->string(255)->notNull(),
                'created_by' => $this->integer()->notNull(),
                'created_at' => $this->datetime()->notNull()->defaultValue(new \yii\db\Expression("NOW()"))
            )
        );

        $this->createIndex('idx-products-created_by', 'products', 'created_by');
        $this->createIndex('idx-products-category_id', 'products', 'category_id');

        $this->addForeignKey(
            'fk-products-category_id',
            'products',
            'category_id',
            'categories',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey("fk-products-category_id", "products");
        $this->dropIndex('idx-products-created_by', 'products');
        $this->dropIndex('idx-products-category_id', 'products');

        $this->dropTable($this->tableName);
        
    }

}
