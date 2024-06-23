<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 * @property int $id
 * @property int $station_id
 * @property string $direction
 * @property string $action
 * @property string $sound
 */
class StationsAudio extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'stations_audio';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['station_id', 'direction', 'action'], 'required'],
            [['station_id'], 'integer'],
            [['direction', 'action'], 'string'],
            [['sound'], 'string', 'max' => 500],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    /**
     * @return array{id: string, station_id: string, direction: string, action: string, sound: string}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'direction' => 'Direction',
            'action' => 'Action',
            'sound' => 'Sound',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getStations(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }
}