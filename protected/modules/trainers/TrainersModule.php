<?php
class TrainersModule extends CWebModule
{
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		
		// import the module-level models and components
		$this->setImport(array(
			'trainers.models.*',
			'trainers.components.*',
		));
		
		$this->setComponents(array(
            'errorHandler'=>array(
                'errorAction'=>'/trainers/default/error',
			),
            'user'=>array(
                'class'=>'WebTrainers',  
				'allowAutoLogin'=>true,				
                'loginUrl'=>Yii::app()->createUrl('/trainers/default/login'),
            ),
        ));
		
		Yii::app()->user->setStateKeyPrefix('_parent');
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			Yii::app()->errorHandler->errorAction='trainers/default/error';

			$route = $controller->id . '/' . $action->id;

			$publicPages = array(
				'default/login',
				'default/error',
			);
			
			// if(Yii::app()->getModule('training')->user->isGuest && !in_array($route,$publicPages))
			if(Yii::app()->getModule('trainers')->user->isGuest && !in_array($route,$publicPages))
			{            
				Yii::app()->getModule('trainers')->user->loginRequired();                
			}
			else
				return true;
		}
		else
			return false;
	}
}
?>