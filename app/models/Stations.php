<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property string $external_id
 * @property string $number
 * @property int $line_id
 * @property string $name
 * @property int $cross_line_id
 * @property string $cross_type
 * @property int $crossPlatform
 * @property string $crossPlatformColor
 * @property string $scheme
 * @property int $sort
 * @property int $active
 */
class Stations extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'stations';
    }

    /**
     * @return array
     */
    public function rules(): array
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

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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

    /**
     * @return string[]
     */
    public function fields(): array
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

    /**
     * @return ActiveQuery
     */
    public function getLine(): ActiveQuery
    {
        return $this->hasOne(Lines::class, ['id' => 'line_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsTranslations(): ActiveQuery
    {
        return $this->hasMany(StationsTranslation::class, ['station_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsTransfers(): ActiveQuery
    {
        return $this->hasMany(StationsTransfers::class, ['station_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsTransfersTo(): ActiveQuery
    {
        return $this->hasMany(StationsTransfers::class, ['station_to_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsAudio(): ActiveQuery
    {
        return $this->hasMany(StationsAudio::class, ['station_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsFeatures(): ActiveQuery
    {
        return $this->hasMany(StationsFeatures::class, ['station_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsExits(): ActiveQuery
    {
        return $this->hasMany(StationsExits::class, ['station_id' => 'id']);
    }
}