<?php

namespace app\controllers;



use app\models\Languages;
use app\models\Lines;
use app\models\LinesTranslation;
use Yii;
use yii\rest\ActiveController;
use yii\web\Response;

class LinesController extends ActiveController
{
    /**
     * @var string
     */
    public $modelClass = Lines::class;

    /**
     * @return array
     */
    public function actions(): array
    {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }


    /**
     * @return array|string[]
     */
    public function actionCreate(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $line = new Lines();
        // Get data from POST request
        $data = Yii::$app->request->post();

        if ($line->load($data, '') && $line->validate()) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($line->save()) {
                    if (!empty($data['linesTranslations'])) {
                        foreach ($data['linesTranslations'] as $translationData) {
                            $translation = new LinesTranslation();

                            $translation->line_id = $line->id;
                            $translation->language_id = $translationData;
                            $translation->value = $line->name;
                            if ($translation->load($translationData, '') && $translation->validate()) {
                                if (!$translation->save()) {
                                    $transaction->rollBack();
                                    return [
                                        'status' => 'error',
                                        'message' => 'Failed to save translation',
                                        'errors' => $translation->errors,
                                    ];
                                }
                            } else {
                                $transaction->rollBack();
                                return [
                                    'status' => 'error',
                                    'message' => 'Translation validation failed',
                                    'errors' => $translation->errors,
                                ];
                            }
                        }
                    }
                    $transaction->commit();
                    return [
                        'status' => 'success',
                        'message' => 'Lines created successfully',
                    ];
                } else {
                    return [
                        'status' => 'error',
                        'message' => 'Failed to create lines',
                        'errors' => $line->errors,
                    ];
                }
            } catch (\Exception $exception) {
                $transaction->rollBack();
                return [
                    'status' => 'error',
                    'message' => 'An error occurred while saving the line',
                    'errors' => $exception->getMessage(),
                ];
            }
        } else {
            return [
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $line->errors,
            ];
        }
    }
}