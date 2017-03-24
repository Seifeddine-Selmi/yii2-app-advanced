<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "product_item".
 *
 * @property integer $id
 * @property string $product_item_no
 * @property double $quantity
 * @property integer $product_id
 *
 * @property Product $product
 */
class ProductItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product_item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_item_no', 'quantity'], 'required'],
            [['quantity'], 'number'],
            [['product_id'], 'integer'],
            [['product_item_no'], 'string', 'max' => 10],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_item_no' => 'Product Item No',
            'quantity' => 'Quantity',
            'product_id' => 'Product ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
}
