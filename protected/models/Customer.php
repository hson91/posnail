<?php

/**
 * This is the model class for table "customer".
 *
 * The followings are the available columns in table 'customer':
 * @property integer $id
 * @property integer $pk_s_id
 * @property integer $s_store_id
 * @property string $s_code
 * @property string $s_name
 * @property string $s_address
 * @property string $s_hand_phone
 * @property string $s_home_phone
 * @property string $s_email
 * @property string $s_image_server
 * @property integer $i_level
 * @property interger $i_flag_sync;
 * @property integer $i_flag_deleted
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class Customer extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Customer the static model class
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
		return 'customer';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pk_s_id, s_store_id', 'required'),
			array('i_level, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_code, s_name, s_address, s_email', 'length', 'max'=>255),
			array('s_hand_phone, s_home_phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pk_s_id, s_store_id, s_code, s_name, s_address, s_hand_phone, s_home_phone, s_email, s_image_server, s_image_local, i_level, i_flag_sync, i_flag_deleted, i_disable, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
			's_store_id' => 'Store',
			's_code' => 'Code',
			's_name' => 'Name',
			's_address' => 'Address',
			's_hand_phone' => 'Hand Phone',
			's_home_phone' => 'Home Phone',
			's_email' => 'Email',
			's_image_server' => 'Image',
			'i_level' => 'Level',
			'i_flag_deleted' => 'Deleted',
			'i_disable' => 'Disable',
			'i_inserted' => 'i_inserted',
			'i_updated' => 'i_updated',
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
		$criteria->compare('pk_s_id',$this->pk_s_id);
		$criteria->compare('s_store_id',Yii::app()->user->storeID);
		$criteria->compare('s_code',$this->s_code,true);
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('s_address',$this->s_address,true);
		$criteria->compare('s_hand_phone',$this->s_hand_phone,true);
		$criteria->compare('s_home_phone',$this->s_home_phone,true);
		$criteria->compare('s_email',$this->s_email,true);
		$criteria->compare('s_image_server',$this->s_image_server,true);
		$criteria->compare('i_level',$this->i_level);
		$criteria->compare('i_flag_deleted',0);
		$criteria->compare('i_disable',$this->i_disable);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}