<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property int $active
 * @property int $name
 * @property int $code
 * @property int $sort
 */
class Languages extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'languages';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['active', 'sort'], 'integer'],
            [['name', 'code', 'sort'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 50],
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'active' => 'Active',
            'name' => 'Name',
            'code' => 'Code',
            'sort' => 'Sort',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getLinesTranslations(): ActiveQuery
    {
        return $this->hasMany(LinesTranslation::class, ['language_id' => 'id']);
    }

    /**
     * @return ActiveQuery
     */
    public function getStationsTranslation(): ActiveQuery
    {
        return $this->hasMany(StationsTranslation::class, ['language_id' => 'id']);
    }
}