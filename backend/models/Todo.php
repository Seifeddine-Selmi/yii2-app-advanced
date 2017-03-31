<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "todo".
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property string $created_date
 */
class Todo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'todo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_date'], 'required'],
            [['status'], 'integer'],
            [['created_date'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'created_date' => 'Created Date',
        ];
    }
}
