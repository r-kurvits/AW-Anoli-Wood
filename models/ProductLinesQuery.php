<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductLines]].
 *
 * @see ProductLines
 */
class ProductLinesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductLines[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductLines|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
