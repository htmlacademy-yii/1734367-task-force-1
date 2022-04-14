<?php

namespace frontend\controllers;

use frontend\forms\RegistrationForm;
use frontend\models\City;
use frontend\models\User;
use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;

class RegistrationController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['@'],
                        'denyCallback' => function($rule, $action) {
                            return $action->controller->redirect('tasks');
                        }
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws Exception
     */
    public function actionIndex()
    {
        $registrationForm = new RegistrationForm();

        $cities = City::getCities();


        if (Yii::$app->request->isPost) {
            $registrationForm->load(Yii::$app->request->post());

            if ($registrationForm->validate()) {
                $user = new User();
                $user->name = $registrationForm->name;
                $user->email = $registrationForm->email;
                $user->password = Yii::$app->security->generatePasswordHash($registrationForm->password);
                $user->city_id = $registrationForm->city_id;

                $user->save();
                $this->goHome();
            }
        }

        return $this->render('index', [
            'title' => 'Регистрация',
            'registrationForm' => $registrationForm,
            'cities' => $cities,
        ]);
    }
}