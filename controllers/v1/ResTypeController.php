<?php

namespace app\controllers\v1;

use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\web\BadRequestHttpException;

class ResTypeController extends BaseApiController
{
    public $modelClass = 'app\models\v1\V1ResType';

}

?>