<?php

/**
 * This is the model class for table "reference".
 *
 * The followings are the available columns in table 'reference':
 * @property integer $id
 * @property integer $s_store_id
 * @property string $s_key
 * @property string $s_value
 * @property string $s_description
 * @property interger $i_flag_sync;
 * @property integer $i_flag_deleted
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class Reference extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reference the static model class
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
		return 'reference';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('s_store_id, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_key, s_value', 'length', 'max'=>255),
			array('s_description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, s_store_id, s_key, s_value, s_description, i_flag_sync, i_flag_deleted, i_disable, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
			's_store_id' => 'I Store',
			's_key' => 'S Key',
			's_value' => 'S Value',
			's_description' => 'S Description',
			'i_flag_deleted' => 'I Flag Deleted',
			'i_disable' => 'I Disable',
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
		$criteria->compare('s_store_id',Yii::app()->user->storeID);
		$criteria->compare('s_key',$this->s_key,true);
		$criteria->compare('s_value',$this->s_value,true);
		$criteria->compare('s_description',$this->s_description,true);
		$criteria->compare('i_flag_deleted',$this->i_flag_deleted);
		$criteria->compare('i_disable',$this->i_disable);
		$criteria->compare('i_inserted',$this->i_inserted);
		$criteria->compare('i_updated',$this->i_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}