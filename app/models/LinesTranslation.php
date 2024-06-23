<?php

namespace app\models;

use yii\db\ActiveQuery;
use yii\db\ActiveRecord;


/**
 *That is the model class for table "lines".
 *
 * @property int $id
 * @property int $line_id
 * @property int $language_id
 * @property string $value
 */
class LinesTranslation extends ActiveRecord
{
    /**
     * @return string
     */
    public static function tableName(): string
    {
        return 'lines_translation';
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            [['language_id', 'value'], 'required'],
            [['value'], 'string', 'max' => 255],
            [['language_id', 'line_id'], 'integer'],
            [['language_id'], 'exist', 'skipOnError' => true, 'targetClass' => Languages::class, 'targetAttribute' => ['language_id' => 'id']],
            [['line_id'], 'exist', 'skipOnError' => true, 'targetClass' => Lines::class, 'targetAttribute' => ['line_id' => 'id']]
        ];
    }

    /**
     * @return string[]
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'line_id' => 'Line ID',
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
            'line_id',
            'language_id',
            'value',
            'languages',
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
    public function getLanguages(): ActiveQuery
    {
        return $this->hasOne(Languages::class, ['id' => 'language_id']);
    }
}