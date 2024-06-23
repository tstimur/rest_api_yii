<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property int $station_id
 * @property int $language_id
 * @property string $value
 */
class StationsTranslation extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'stations_translation';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['station_id', 'language_id', 'value'], 'required'],
            [['station_id', 'language_id'], 'integer'],
            [['value'], 'string', 'max' => 255],
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
            'language_id' => 'Language ID',
            'value' => 'Value',
        ];
    }

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return [
            'id',
            'station_id',
            'language_id',
            'value',
            'languages',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getStations(): ActiveQuery
    {
        return $this->hasOne(Stations::class, ['id' => 'station_id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getLanguages(): ActiveQuery
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }
}