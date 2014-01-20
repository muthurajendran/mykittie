<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

	private $_id;
	
    public function authenticate()
    {
        //$record=User::model()->findByAttributes(array('username'=>$this->username));
    	//die(var_dump($this->username));

        $username=strtolower($this->username);

        $record = Users::model()->find('email=:em', array(':em'=>$this->username)); 
        
        $ph=new PasswordHash(Yii::app()->params['phpass']['iteration_count_log2'], Yii::app()->params['phpass']['portable_hashes']);
        
        //die(var_dump($ph->CheckPassword($this->password, $record->password)));

        if($record===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        else if(!$ph->CheckPassword($this->password, $record->password))
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        else
        {
        	//die("hi");

            $this->_id=$record->id;
            $this->setState('username', $record->email);
       		Yii::app()->session['loggedin'] = true;
            $this->errorCode=self::ERROR_NONE;
        }
        return $this->errorCode;
    }
 
    public function getId()
    {
        return $this->_id;
    }

    /*
	public function authenticate()
	{
		$users=array(
			// username => password
			'demo'=>'demo',
			'admin'=>'admin',
		);
		if(!isset($users[$this->username]))
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		elseif($users[$this->username]!==$this->password)
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else
			$this->errorCode=self::ERROR_NONE;
		return !$this->errorCode;
	} */
}