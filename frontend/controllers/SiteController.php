<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use GuzzleHttp\Client;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use frontend\forms\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
//class SiteController extends Controller
class SiteController extends SecuredController
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $loginForm = new LoginForm();

        if (Yii::$app->request->getIsPost()) {
            $loginForm->load(Yii::$app->request->post());

            if ($loginForm->validate()) {
                $user = $loginForm->getUser();
                Yii::$app->user->login($user);
                return $this->redirect(['tasks/index']);
            }

        }

        $loginForm->password = '';

        Yii::$app->session->setFlash('error', 'Неправильный email или пароль');
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['landing/index']);
    }

    public function actionVerify()
    {
        if (Yii::$app->request->getIsGet()) {
            // Получение code
            $code = Yii::$app->request->get();

            // Получение access_token
            $params = [
                'client_id' => 51474476,
                'client_secret' => 'JaiEUodX72fVGph1cA54',
                'code' => $code['code'],
                'redirect_uri' => 'http://yii-taskforce/site/verify',
            ];
            $client = new Client();
            $url = "https://oauth.vk.com/access_token?client_id={$params['client_id']}&client_secret={$params['client_secret']}&redirect_uri={$params['redirect_uri']}&code={$params['code']}";
            $response = $client->post($url);
            $contentJson = $response->getBody()->getContents();
            $content = json_decode($contentJson);


            // Получения дополнительных данных о пользователе.
            $params2 = [
                'uids' => $content->user_id,
                'fields' => 'uid,first_name,last_name,screen_name,bdate,city',
                'access_token' => $content->access_token,
                'v' => '5.101',
            ];
            $url2 = "https://api.vk.com/method/users.get?uids={$params2['uids']}&fields={$params2['fields']}&access_token={$params2['access_token']}&v={$params2['v']}";
            $response2 = $client->post($url2);
            $contentJson2 = $response2->getBody()->getContents();
            $content2 = json_decode($contentJson2);

            // Обработка данных
            $res = [];
            foreach ($content2->response as $item) {
                $res = [
                    'id' => $item->id,
                    'bdate' => $item->bdate,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'city' => $item->city->title,
                ];
            }
        }
    }

//    /**
//     * Displays contact page.
//     *
//     * @return mixed
//     */
//    public function actionContact()
//    {
//        $model = new ContactForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
//                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
//            } else {
//                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
//            }
//
//            return $this->refresh();
//        }
//
//        return $this->render('contact', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Displays about page.
//     *
//     * @return mixed
//     */
//    public function actionAbout()
//    {
//        return $this->render('about');
//    }
//
//    /**
//     * Signs user up.
//     *
//     * @return mixed
//     */
//    public function actionSignup()
//    {
//        $model = new SignupForm();
//        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
//            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
//            return $this->goHome();
//        }
//
//        return $this->render('signup', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Requests password reset.
//     *
//     * @return mixed
//     */
//    public function actionRequestPasswordReset()
//    {
//        $model = new PasswordResetRequestForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//
//                return $this->goHome();
//            }
//
//            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
//        }
//
//        return $this->render('requestPasswordResetToken', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Resets password.
//     *
//     * @param string $token
//     * @return mixed
//     * @throws BadRequestHttpException
//     */
//    public function actionResetPassword($token)
//    {
//        try {
//            $model = new ResetPasswordForm($token);
//        } catch (InvalidArgumentException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->session->setFlash('success', 'New password saved.');
//
//            return $this->goHome();
//        }
//
//        return $this->render('resetPassword', [
//            'model' => $model,
//        ]);
//    }
//
//    /**
//     * Verify email address
//     *
//     * @param string $token
//     * @throws BadRequestHttpException
//     * @return yii\web\Response
//     */
//    public function actionVerifyEmail($token)
//    {
//        try {
//            $model = new VerifyEmailForm($token);
//        } catch (InvalidArgumentException $e) {
//            throw new BadRequestHttpException($e->getMessage());
//        }
//        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
//            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
//            return $this->goHome();
//        }
//
//        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
//        return $this->goHome();
//    }
//
//    /**
//     * Resend verification email
//     *
//     * @return mixed
//     */
//    public function actionResendVerificationEmail()
//    {
//        $model = new ResendVerificationEmailForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
//                return $this->goHome();
//            }
//            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
//        }
//
//        return $this->render('resendVerificationEmail', [
//            'model' => $model
//        ]);
//    }
}
