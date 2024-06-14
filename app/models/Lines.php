<?php

namespace app\models;


use yii\db\ActiveRecord;

/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property string $number
 * @property string $name
 * @property string $color
 * @property string|null $style
 * @property int|null $circular
 * @property string|null $external_id
 * @property int|null $sort
*/
class Lines extends ActiveRecord
{
    public static function tableName()
    {
        return 'lines';
    }

    public function rules()
    {
        return [
            [['number', 'name', 'color'], 'required'],
            [['style'], 'string'],
            [['circular', 'sort'], 'integer'],
            [['number'], 'string', 'max' => 10],
            [['name'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['external_id'], 'string', 'max' => 128],
            [['number', 'name'], 'unique', 'targetAttribute' => ['number', 'name']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'name' => 'Name',
            'color' => 'Color',
            'style' => 'Style',
            'circular' => 'Circular',
            'external_id' => 'External ID',
            'sort' => 'Sort',
        ];
    }

    public function extraFields()
    {
        return [
            'translations',
            'stations'
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(LinesTranslation::class, ['line_id'=>'id']);
    }

    public function getStations()
    {
        return $this->hasMany(Stations::class, ['line_id' => 'id']);
    }

}