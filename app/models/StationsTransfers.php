<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property int $station_id
 * @property int $station_to_id
 * @property string $type
 * @property string $name
 * @property string $code
 * @property string $icon
 */
class StationsTransfers extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'stations_transfers';
    }

    /**
     * @return array
     */
    public function rules(): array
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

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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

    /**
     * @return ActiveQuery
     */
    public function getStation(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationTo(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['id' => 'station_to_id']);
    }
}