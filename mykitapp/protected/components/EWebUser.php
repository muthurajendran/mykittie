<?php 
class EWebUser extends CWebUser{
 
    protected $_model;
 
    function isAdmin(){
        $user = $this->loadUser();
        if ($user)
           return $user->role;
        return false;
    }
    
    
 
    // Load user model.
    protected function loadUser()
    {
        if ( $this->_model === null ) {
        		if($this->id)
                	$this->_model = Users::model()->findByPk($this->id);
                else 
                	$this->_model = "";
        }
        //die(var_dump($this->_model));
        return $this->_model;
    }
    
  
    
	/* public function logout($destroySession= true)
    {
        // I always remove the session variable model.
        Yii::app()->getSession()->remove('model');
        parent::logout();
    } */
}