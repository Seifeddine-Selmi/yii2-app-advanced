<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\User;

/**
 * UserSearch represents the model behind the search form about `backend\models\User`.
 */
class UserSearch extends User
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const ROLE_USER = 10;
    const ROLE_MODERATOR = 20;
    const ROLE_ADMIN = 30;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'first_name', 'last_name', 'status', 'role'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
           // 'role' => $this->role,
            'role' => $this->getRoleNumber(),
            //'status' => $this->status,
            'status' => $this->getStatusNumber(),

        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name]);

        return $dataProvider;
    }

    /**
     * @return array User Roles List
     */
    public static function getRolesList()
    {
        return [
            'user' => self::ROLE_USER,
            'moderator' =>  self::ROLE_MODERATOR,
            'admin' => self::ROLE_ADMIN ,
        ];
    }

    /**
     * @return string  User Role
     */
    public function getRoleNumber()
    {
        $roles = array("user", "moderator", "admin");
        if (in_array(strtolower($this->role), $roles))
           return self::getRolesList()[strtolower($this->role)];
        return "";
    }

    /**
     * @return array User Status List
     */
    public static function getStatusList()
    {
        return [
            'active' => self::STATUS_ACTIVE,
            'inactive' =>  self::STATUS_DELETED,
        ];
    }

    /**
     * @return string  User Status
     */
    public function getStatusNumber()
    {
        $status = array("active", "inactive");

        if (in_array(strtolower($this->status), $status))
            return self::getStatusList()[strtolower($this->status)];
        return "";
    }
}
