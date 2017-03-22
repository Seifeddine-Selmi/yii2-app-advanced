<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "email".
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $subject
 * @property string $content
 * @property string $attachment
 */
class Email extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'subject'], 'required'],
            [['content'], 'string'],
            [['name', 'subject'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 200],
            [['attachment'], 'string', 'max' => 255],
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
            'email' => 'Email',
            'subject' => 'Subject',
            'content' => 'Content',
            'attachment' => 'Attachment',
        ];
    }
}
