<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property int $station_id
 * @property int $feature_id
 */
class StationsFeatures extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'stations_features';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['feature_id'], 'required'],
            [['feature_id', 'station_id'], 'integer'],
            [['feature_id'], 'exist', 'skipOnError' => true, 'targetClass' => Services::class, 'targetAttribute' => ['feature_id' => 'id']],
            [['station_id'], 'exist', 'skipOnError' => true, 'targetClass' => Stations::class, 'targetAttribute' => ['station_id' => 'id']]
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
            'feature_id' => 'Feature ID',
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
            'feature_id',
            'services',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getServices(): ActiveQuery
    {
        return $this->hasOne(Services::class, ['id' => 'feature_id']);
    }
}