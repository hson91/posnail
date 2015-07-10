<?php

/**
 * This is the model class for table "order_detail".
 *
 * The followings are the available columns in table 'order_detail':
 * @property integer $id
 * @property string $pk_s_id
 * @property integer $s_order_id
 * @property integer $s_store_id
 * @property integer $s_server_id
 * @property string $s_service_name
 * @property string $s_service_alias
 * @property string $s_service_price
 * @property integer $s_user_id
 * @property integer $i_qty
 * @property string $s_total
 * @property integer $i_flag_sync
 * @property integer $i_flag_deleted
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class OrderDetail extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OrderDetail the static model class
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
		return 'order_detail';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_qty, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_service_name, pk_s_id, s_service_alias, s_total', 'length', 'max'=>255),
			array('s_service_price', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pk_s_id, s_order_id, s_store_id, s_server_id, s_service_name, s_service_alias, s_service_price, s_user_id, i_qty, s_total, i_flag_sync, i_flag_deleted, i_disable, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
			'pk_s_id' => 'S ID',
			's_order_id' => 'I Order',
			's_store_id' => 'I Store',
			's_server_id' => 'I Server',
			's_service_name' => 'S Service Name',
			's_service_alias' => 'S Service Alias',
			's_service_price' => 'S Service Price',
			's_user_id' => 'I User',
			'i_qty' => 'I Qty',
			's_total' => 'S Total',
			'i_flag_deleted' => 'I Flag Delete',
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
		$criteria->compare('pk_s_id',$this->pk_s_id);
		$criteria->compare('s_order_id',$this->s_order_id);
		$criteria->compare('s_store_id',Yii::app()->user->storeID);
		$criteria->compare('s_server_id',$this->s_server_id);
		$criteria->compare('s_service_name',$this->s_service_name,true);
		$criteria->compare('s_service_alias',$this->s_service_alias,true);
		$criteria->compare('s_service_price',$this->s_service_price,true);
		$criteria->compare('s_user_id',$this->s_user_id);
		$criteria->compare('i_qty',$this->i_qty);
		$criteria->compare('s_total',$this->s_total,true);
		$criteria->compare('i_flag_deleted',$this->i_flag_deleted);
		$criteria->compare('i_disable',$this->i_disable);
		$criteria->compare('i_inserted',$this->i_inserted);
		$criteria->compare('i_updated',$this->i_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}