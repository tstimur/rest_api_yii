<?php

namespace app\models;

use yii\db\ActiveRecord;

class LinesTranslation extends ActiveRecord
{
    public static function tableName()
    {
        return 'lines_translation';
    }

    public function rules()
    {
        return [
            [['language_id', 'value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['language_id', 'line_id'], 'integer'],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lines::class, 'targetAttribute' => ['line_id' => 'id']]
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'line_id' => 'Line ID',
            'language_id' => 'Language ID',
            'value' => 'Value',
        ];
    }

    public function getLine()
    {
        return $this->hasOne(Lines::class, ['id' => 'line_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }
}