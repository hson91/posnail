<?php

/**
 * This is the model class for table "service_type".
 *
 * The followings are the available columns in table 'service_type':
 * @property integer $id
 * @property integer $pk_s_id
 * @property integer $s_parent_id
 * @property integer $s_store_id
 * @property string $s_name
 * @property string $s_alias
 * @property string $s_image_server
 * @property string $s_summary
 * @property string $s_description
 * @property string $s_params
 * @property interger $i_flag_sync;
 * @property integer $i_flag_delete
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class ServiceType extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ServiceType the static model class
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
		return 'service_type';
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
			array('i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_name, s_alias, s_image_server, s_summary', 'length', 'max'=>255),
			array('s_params', 'length', 'max'=>500),
			array('s_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pk_s_id, s_parent_id, s_store_id, s_name, s_alias, s_image_server, s_image_local, s_summary, s_description, s_params, i_flag_sync, i_flag_deleted, i_disable, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
			's_parent_id' => 'Parent ID',
			's_store_id' => 'Store',
			's_name' => 'Name',
			's_alias' => 'Alias',
			's_image_server' => 'Image',
			's_summary' => 'Summary',
			's_description' => 'Description',
			's_params' => 'Params',
			'i_flag_deleted' => 'Flag Deleted',
			'i_disable' => 'Disable',
			'i_inserted' => 'Inserted',
			'i_updated' => 'Updated',
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
		$criteria->compare('s_parent_id',$this->s_parent_id);
		$criteria->compare('s_store_id',Yii::app()->user->storeID);
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('s_alias',$this->s_alias,true);
		$criteria->compare('s_summary',$this->s_summary,true);
		$criteria->compare('s_description',$this->s_description,true);
		$criteria->compare('s_params',$this->s_params,true);
		$criteria->compare('i_flag_deleted',$this->i_flag_deleted);
		$criteria->compare('i_disable',$this->i_disable);
		$criteria->compare('i_inserted',$this->i_inserted);
		$criteria->compare('i_updated',$this->i_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}