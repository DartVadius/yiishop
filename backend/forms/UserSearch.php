<?php

namespace backend\forms;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use core\entities\user\User;

/**
 * UserSearch represents the model behind the search form about `core\entities\user\User`.
 */
class UserSearch extends Model {

    public $id;
    public $status;
//    public $created_at;
    public $from;
    public $to;
    public $username;
    public $email;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'email'], 'safe'],
            [['from', 'to'], 'date', 'format' => 'php:Y-m-d'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['>=', 'created_at', $this->from ? strtotime($this->from . ' 00:00:00') : null])
            ->andFilterWhere(['<=', 'created_at', $this->to ? strtotime($this->to . ' 23:59:59') : null]);

        return $dataProvider;
    }
}
