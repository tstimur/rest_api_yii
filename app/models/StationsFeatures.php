<?php

namespace app\models;

use yii\db\ActiveRecord;

class StationsFeatures extends ActiveRecord
{
    public static function tableName()
    {
        return 'stations_features';
    }

    public function rules()
    {
        return [
            [['feature_id'], 'required'],
            [['feature_id', 'station_id'], 'integer'],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['feature_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'feature_id' => 'Feature ID',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'station_id',
            'feature_id',
            'services',
        ];
    }

    public function getServices()
    {
        return $this->hasOne(Services::class, ['id' => 'feature_id']);
    }
}