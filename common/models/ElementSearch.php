<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Element;

/**
 * ElementSearch represents the model behind the search form about `common\models\Element`.
 */
class ElementSearch extends Element
{
    public $date_to;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at'], 'integer'],
            [['name', 'description', 'category_id', 'date_to'], 'safe'],
            [['param_done', 'param_all'], 'number'],
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
        $query = Element::find();
        // $query = Element::find()->joinWith('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            // 'categories.name' => $this->category_id,
            // 'param_done' => $this->param_done,
            'param_all' => $this->param_all,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['>=', 'param_done', $this->param_done]);
            // ->andFilterWhere(['like', 'description', $this->description]);
            // ->andFilterWhere(['like', 'categories.name', $this->name]);

        if ($this->date_to) {
            $query->andFilterWhere([
                '<=', 
                'updated_at', 
                strtotime(str_replace('.', '/', $this->date_to)),
            ]);
        }

        return $dataProvider;
    }
}
