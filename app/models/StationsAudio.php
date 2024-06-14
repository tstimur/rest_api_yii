<?php

namespace app\models;

use yii\base\Model;
use yii\db\ActiveRecord;

class StationsAudio extends ActiveRecord
{
    public static function tableName()
    {
        return 'stations_audio';
    }

    public function rules()
    {
        return [
            [['station_id', 'direction', 'action'], 'required'],
            [['station_id'], 'integer'],
            [['direction', 'action'], 'string'],
            [['sound'], 'string', 'max' => 500],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'direction' => 'Direction',
            'action' => 'Action',
            'sound' => 'Sound',
        ];
    }

    public function getStations()
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }
}