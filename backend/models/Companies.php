<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "companies".
 *
 * @property integer $company_id
 * @property string $company_name
 * @property string $company_email
 * @property string $company_address
 * @property string $company_created_date
 * @property string $company_status
 * @property string $company_start_date
 *
 * @property Branches[] $branches
 * @property Departments[] $departments
 */
class Companies extends \yii\db\ActiveRecord
{

    public $imageFile;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['company_name', 'company_email', 'company_address', 'company_status'], 'required'],
            [['company_created_date'], 'safe'],
            [['company_start_date'], 'safe'],
            [['company_status'], 'string'],
            [['company_name', 'company_email', 'company_logo'], 'string', 'max' => 100],
            [['company_address'], 'string', 'max' => 255],
            // Custom rule
            [['company_start_date'], 'required'],
            ['company_start_date','checkDate'],

            // File variable
           // [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'jpg, gif, png'],
            ['imageFile', 'image', 'minWidth' => 250,'minHeight' => 250],
            // Combine size and extensions
            // ['imageFile', 'image', 'minWidth' => 250, 'maxWidth' => 250,'minHeight' => 250, 'maxHeight' => 250, 'extensions' => 'jpg, gif, png', 'maxSize' => 1024 * 1024 * 2],
        ];
    }

    public function checkDate($attribute,$params)
    {
        $today = date('Y-m-d');
        $selectedDate = date($this->company_start_date);

        if(strtotime($selectedDate) > strtotime($today))
        {
            $this->addError($attribute,'Company Start Date Must be Smaller than today');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'company_id' => 'Company ID',
            'company_name' => 'Company Name',
            'company_email' => 'Company Email',
            'company_address' => 'Company Address',
            'company_created_date' => 'Company Created Date',
            'company_status' => 'Company Status',
            'company_start_date' => 'Company Start Date',
            'imageFile' => 'Logo',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBranches()
    {
        return $this->hasMany(Branches::className(), ['companies_company_id' => 'company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDepartments()
    {
        return $this->hasMany(Departments::className(), ['companies_company_id' => 'company_id']);
    }


    public static function getCompanies()
    {
        $companies = Companies::find()->all();
        $list = array(null=>'Select Company');
        foreach($companies as $company){
            $list[$company->company_id] = $company->company_name;
        }
        return $list;
    }
}
