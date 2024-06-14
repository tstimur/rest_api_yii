<?php

namespace app\models;

use yii\db\ActiveRecord;

class Languages extends ActiveRecord
{
    public static function tableName()
    {
        return 'languages';
    }

    public function rules()
    {
        return [
            [['active', 'sort'], 'integer'],
            [['name', 'code', 'sort'], 'required'],
            [['name'], 'string', 'max' => 128],
            [['code'], 'string', 'max' => 50],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'active' => 'Active',
            'name' => 'Name',
            'code' => 'Code',
            'sort' => 'Sort',
        ];
    }

    public function getLinesTranslations()
    {
        return $this->hasMany(LinesTranslation::class, ['language_id' => 'id']);
    }
}