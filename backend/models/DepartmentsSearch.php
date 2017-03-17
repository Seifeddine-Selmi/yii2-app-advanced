<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Departments;

/**
 * DepartmentsSearch represents the model behind the search form about `backend\models\Departments`.
 */
class DepartmentsSearch extends Departments
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['department_id'], 'integer'],  // Remove companies_company_id and branches_branch_id in integer array
            [['branches_branch_id', 'companies_company_id', 'department_name', 'department_created_date', 'department_status'], 'safe'],
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
        $query = Departments::find();

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

        // Add join companies for Searching Related Table Data From the GridView
        $query->joinWith('companiesCompany'); // Name of relation in Departments model getCompaniesCompany

        // Add join branches for Searching Related Table Data From the GridView
        $query->joinWith('branchesBranch'); // Name of relation in Departments model getBranchesBranch

        // grid filtering conditions
        $query->andFilterWhere([
            'department_id' => $this->department_id,
           // 'branches_branch_id' => $this->branches_branch_id, // Replace to search branch name
           // 'companies_company_id' => $this->companies_company_id, // Replace to search company name
            'department_created_date' => $this->department_created_date,
        ]);

        $query->andFilterWhere(['like', 'department_name', $this->department_name])
            ->andFilterWhere(['like', 'department_status', $this->department_status])
            ->andFilterWhere(['like', 'companies.company_name', $this->companies_company_id]) //'companies' name of join table
            ->andFilterWhere(['like', 'branches.branch_name', $this->branches_branch_id]); //'branches' name of join table

        return $dataProvider;
    }
}
