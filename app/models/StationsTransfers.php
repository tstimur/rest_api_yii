<?php

namespace app\models;

use yii\db\ActiveRecord;

class StationsTransfers extends ActiveRecord
{
    public static function tableName()
    {
        return 'stations_transfers';
    }

    public function rules()
    {
        return [
            [['type', 'station_id', 'station_to_id'], 'required'],
            [['station_to_id', 'station_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 50],
            [['icon'], 'string', 'max' => 500],
            [['type'], 'string'],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id'],],
            [['station_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_to_id' => 'id'],]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'station_to_id' => 'Station To ID',
            'type' => 'Type',
            'name' => 'Name',
            'code' => 'Code',
            'icon' => 'Icon',
        ];
    }

    public function getStation()
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }

    public function getStationTo()
    {
        return $this->hasOne(Stations::class, ['id' => 'station_to_id']);
    }
}