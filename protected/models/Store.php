<?php

/**
 * This is the model class for table "store".
 *
 * The followings are the available columns in table 'store':
 * @property integer $id
 * @property integer $pk_s_id
 * @property string $s_name
 * @property string $s_image
 * @property string $s_address
 * @property string $s_summary
 * @property integer $i_is_trial
 * @property integer $i_trial_from
 * @property integer $i_trial_to
 * @property integer $i_lock
 * @property string $s_description
 * @property string $s_latitude
 * @property string $s_longitude
 * @property interger $i_flag_sync
 * @property integer $i_flag_deleted
 * @property integer $i_disable
 * @property integer $i_account_manager
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class Store extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Store the static model class
	 */
    public $manager;
    public $status;  
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'store';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pk_s_id', 'required'),
			array('i_is_trial, i_trial_from, i_trial_to, i_lock, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_name, s_address, s_summary, s_latitude, s_longitude', 'length', 'max'=>255),
			array('s_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pk_s_id, s_name, s_image_server, s_image_local, s_address, s_summary, i_is_trial, i_trial_from, i_trial_to, i_lock, s_description, s_latitude, s_longitude, i_flag_sync, i_flag_deleted, i_disable, i_account_manager, i_status, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
            'user' => array(self::HAS_MANY,'User',array('s_store_id' => 'pk_s_id')),
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
            'manager' =>'Manager',
			's_name' => 'Store Name',
			's_image' => 'Store Image',
			's_address' => 'Store Address',
			's_summary' => 'Store Summary',
			'i_is_trial' => 'Is Trial',
			'i_trial_from' => 'Trial From',
			'i_trial_to' => 'Trial To',
			'i_lock' => 'Is Lock',
			's_description' => 'Description',
			's_latitude' => 'Latitude',
			's_longitude' => 'Longitude',
			'i_flag_deleted' => 'Flag Deleted',
			'i_disable' => 'Is Disable',
            'i_status' => 'Status',
			'i_inserted' => 'Inserted',
			'i_updated' => 'Updated',
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search(){
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.s_name',$this->s_name,true);
		$criteria->compare('t.s_address',$this->s_address,true);
		$criteria->compare('t.s_summary',$this->s_summary,true);
		$criteria->compare('t.i_is_trial',$this->i_is_trial);
		$criteria->compare('t.i_trial_from',$this->i_trial_from);
		$criteria->compare('t.i_trial_to',$this->i_trial_to);
		$criteria->compare('t.i_lock',$this->i_lock);
		$criteria->compare('t.s_description',$this->s_description,true);
		$criteria->compare('t.s_latitude',$this->s_latitude,true);
		$criteria->compare('t.s_longitude',$this->s_longitude,true);
		$criteria->compare('t.i_flag_deleted',$this->i_flag_deleted);
		$criteria->compare('t.i_disable',$this->i_disable);
        $criteria->compare('t.i_status',$this->i_status);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function user(){
        return User::model()->findAll('s_store_id = :s_store_id',array(':s_store_id'=>$this->pk_s_id));
    }
    public function userManager(){
        return User::model()->find('s_store_id = :s_store_id and i_manager = 1',array(':s_store_id'=>$this->pk_s_id));
    }
    public function getUser(){
        //$users = User::model()->findAll();
        $users = Yii::app()->db->createCommand()
                    ->select('pk_s_id,s_fullname,s_username')
                    ->from('user')
                    ->where('( s_store_id IS NULL OR s_store_id = "" ) AND i_manager = 1 AND i_shopping = 1')
                    ->queryAll();
        return $users;
    }
    public function setStatus(){
        $status  = 2;
        if($this->i_is_trial == 1){
            $status = 5;
            if($this->i_trial_to > 0 && $this->i_trial_to < time()){
                $status = 6;
            }
        }elseif($this->i_disable == 1){
            $status = 4;
            if($this->i_lock > 0){
                $status = 1;
            }
        }
        return $status;
    }
    public function beforeSave(){
        if($this->userManager() != null){
            $this->i_account_manager = 1;
        }else{
            $this->i_account_manager = 0;
        }
        return parent::beforeSave();
    }
}