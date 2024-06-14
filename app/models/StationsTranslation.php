<?php

namespace app\models;

use yii\db\ActiveRecord;

class StationsTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'stations_translation';
    }

    public function rules()
    {
        return [
            [['station_id', 'language_id', 'value'], 'required'],
            [['station_id', 'language_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'language_id' => 'Language ID',
            'value' => 'Value',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'station_id',
            'language_id',
            'value',
            'languages',
        ];
    }

    public function getStations()
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }

    public function getLanguages()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }
}