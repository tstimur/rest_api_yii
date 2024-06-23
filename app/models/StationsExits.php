<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $station_id
 * @property string $direction
 * @property string $doors
 */
class StationsExits extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'stations_exits';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['station_id', 'direction', 'doors'], 'required'],
            [['station_id'], 'integer'],
            [['direction', 'doors'], 'string'],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'station_id' => 'Station ID',
            'direction' => 'Direction',
            'doors' => 'Doors',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getStation(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }
}