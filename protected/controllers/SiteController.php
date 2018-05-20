<?php

class SiteController extends Controller
{
	public $layout='column1';

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),

            'upload'=>array(
                'class'=>'xupload.actions.XUploadAction',
                'path' =>Yii::app() -> getBasePath() . "/../uploads",
                'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
            ),
		);
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model = new ContactForm;

        if(isset($_POST['ajax'])) {
            if ($_POST['ajax']=='contact-form') {
                echo CActiveForm::validate($model);
            }
            Yii::app()->end();
        }

		if(isset($_POST['ContactForm']))
		{
			$model->attributes = $_POST['ContactForm'];
            $xUploadFormData = $_POST['XUploadForm'];

            if(isset($xUploadFormData['files']) && is_array($xUploadFormData['files'])) {
                foreach ($xUploadFormData['files'] as $file) {

                    $realPath = realpath( Yii::app( )->getBasePath( )."/..".$file);
                    if(file_exists($realPath)) {
                        $attachment[] = $realPath;
                    }
                }
            }

            if($model->validate())
			{
                $mail = new YiiMailer('contact', $model->attributes);
                $mail->isSMTP();
                $mail->setLayout('mail', array('description' => 'Контакты - форма'));
                $mail->setHTMLView('contact');
                $mail->setFrom(Yii::app()->params['adminEmail'], 'Форма обратной связи');
                $mail->setTo($model->email);
                $mail->setSubject($model->subject);
                if(is_array($attachment)) {
                    $mail->setAttachment($attachment);
                }

                if ($mail->send()) {
                    Yii::app()->user->setFlash('contact','Письмо успешно отправлено');
                } else {
                    Yii::app()->user->setFlash('error','Ошибка при отправке письма: ' . $mail->getError());
                }

                if(is_array($attachment)) {
                    foreach($attachment as $file) {
                        if(file_exists($file)) {
                            unlink($file);
                        }
                    }
                }

				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
        Yii::import("xupload.models.XUploadForm");
        $attachModel = new XUploadForm;
		$this->render('contact',array('model'=>$model, 'attachModel' => $attachModel));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		if (!defined('CRYPT_BLOWFISH')||!CRYPT_BLOWFISH)
			throw new CHttpException(500,"This application requires that PHP was compiled with Blowfish support for crypt().");

		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}
