<?php

/**
 * This is the model class for table "log_login".
 *
 * The followings are the available columns in table 'log_login':
 * @property integer $id
 * @property string $pk_s_id
 * @property string $s_username
 * @property string $s_email
 * @property string $s_ip
 * @property string $s_browser
 * @property integer $s_count_login
 * @property integer $i_time_log
 * @property string $s_issua_log
 * @property integer $i_status
 * @property string $s_params
 */
class LogLogin extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LogLogin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'log_login';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, pk_s_id, s_username, s_email, s_ip, s_browser, s_count_login, i_time_log, s_issua_log, i_status, s_params', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'pk_s_id' => 'ID',
			's_username' => 'Username',
			's_email' => 'Email',
			's_ip' => 'IP Address',
			's_browser' => 'Browser',
			's_count_login' => 'Count Login',
			'i_time_log' => 'Time Log',
			's_issua_log' => 'Issuas',
			'i_status' => 'Status',
			's_params' => 'Params',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('pk_s_id',$this->pk_s_id,true);
		$criteria->compare('s_username',$this->s_username,true);
		$criteria->compare('s_email',$this->s_email,true);
		$criteria->compare('s_ip',$this->s_ip,true);
		$criteria->compare('s_browser',$this->s_browser,true);
		$criteria->compare('s_count_login',$this->s_count_login);
		$criteria->compare('i_time_log',$this->i_time_log);
		$criteria->compare('s_issua_log',$this->s_issua_log,true);
		$criteria->compare('i_status',$this->i_status);
		$criteria->compare('s_params',$this->s_params,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function beforeSave(){
        if($this->s_count_login < 5){
            $this->s_count_login = $this->s_count_login + 1;
        }
        return true;
        
    }
}