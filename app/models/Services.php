<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property int $code
 * @property int $name
 * @property int $icon
 */
class Services extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'services';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 50],
            [['name', 'icon'], 'string', 'max' => 500],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'icon' => 'Icon',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsFeatures(): ActiveQuery
    {
        return $this->hasMany(StationsFeatures::class, ['feature_id' => 'id']);
    }
}