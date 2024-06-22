<?php

namespace app\models;

use yii\db\ActiveRecord;

class Stations extends ActiveRecord
{
    public static function tableName()
    {
        return 'stations';
    }
    public function rules()
    {
        return [
            [['line_id', 'name'], 'required'],
            [['line_id', 'cross_line_id', 'crossPlatform', 'sort', 'active'], 'integer'],
            [['cross_type'], 'string'],
            [['external_id', 'number', 'name'], 'string', 'max' => 128],
            [['crossPlatformColor'], 'string', 'max' => 7],
            [['scheme'], 'string', 'max' => 500],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lines::class, 'targetAttribute' => ['line_id' => 'id']],
            [['cross_line_id'],'exist', 'skipOnError' => true, 'targetClass' => Lines::class, 'targetAttribute' => ['cross_line_id' => 'id'],]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'external_id' => 'External ID',
            'number' => 'Number',
            'line_id' => 'Line ID',
            'name' => 'Name',
            'cross_line_id' => 'Cross Line ID',
            'cross_type' => 'Cross Type',
            'crossPlatform' => 'Cross Platform',
            'crossPlatformColor' => 'Cross Platform Color',
            'scheme' => 'Scheme',
            'sort' => 'Sort',
            'active' => 'Active',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'external_id',
            'line_id',
            'name',
            'stationsAudio',
            'stationsExits',
            'stationsFeatures',
            'stationsTranslations',
            'stationsTransfers'
        ];
    }

    public function getLine()
    {
        return $this->hasOne(Lines::class, ['id' => 'line_id']);
    }
    public function getStationsTranslations()
    {
        return $this->hasMany(StationsTranslation::class, ['station_id' => 'id']);
    }
    public function getStationsTransfers()
    {
        return $this->hasMany(StationsTransfers::class, ['station_id' => 'id']);
    }
    public function getStationsTransfersTo()
    {
        return $this->hasMany(StationsTransfers::class, ['station_to_id' => 'id']);
    }
    public function getStationsAudio()
    {
        return $this->hasMany(StationsAudio::class, ['station_id' => 'id']);
    }

    public function getStationsFeatures()
    {
        return $this->hasMany(StationsFeatures::class, ['station_id' => 'id']);
    }

    public function getStationsExits()
    {
        return $this->hasMany(StationsExits::class, ['station_id' => 'id']);
    }
}