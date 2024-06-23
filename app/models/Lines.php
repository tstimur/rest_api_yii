<?php

namespace app\models;


use yii\db\ActiveQuery;
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
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'lines';
    }

    /**
     * @return array
     */
    public function rules(): array
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

    /**
     * @return string[]
     */
    public function attributeLabels(): array
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

    /**
     * @return string[]
     */
    public function fields(): array
    {
        return ['id', 'number', 'name', 'color', 'style', 'circular', 'external_id', 'sort', 'linesTranslations', 'stations'];
    }

    /**
     * @return string[]
     */
    public function extraFields(): array
    {
        return [
            'linesTranslations',
            'stations'
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLinesTranslations(): ActiveQuery
    {
        return $this->hasMany(LinesTranslation::class, ['line_id'=>'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStations(): ActiveQuery
    {
        return $this->hasMany(Stations::class, ['line_id' => 'id']);
    }
}