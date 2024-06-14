<?php

namespace app\models;

use yii\db\ActiveRecord;

class Services extends ActiveRecord
{
    public static function tableName()
    {
        return 'services';
    }

    public function rules()
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 50],
            [['name', 'icon'], 'string', 'max' => 500],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'icon' => 'Icon',
        ];
    }

    public function getStationsFeatures()
    {
        return $this->hasMany(StationsFeatures::class, ['feature_id' => 'id']);
    }
}