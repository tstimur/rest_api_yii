<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class StationsExits extends ActiveRecord
{
    public static function tableName()
    {
        return 'stations_exits';
    }

    public function rules()
    {
        return [
            [['station_id', 'direction', 'doors'], 'required'],
            [['station_id'], 'integer'],
            [['direction', 'doors'], 'string'],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'direction' => 'Direction',
            'doors' => 'Doors',
        ];
    }

    public function getStation()
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }
}