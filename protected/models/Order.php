<?php

/**
 * This is the model class for table "order".
 *
 * The followings are the available columns in table 'order':
 * @property integer $id
 * @property integer $pk_s_id
 * @property integer $s_store_id
 * @property integer $s_user_id
 * @property integer $s_customer_id
 * @property string $s_customer_name
 * @property string $s_customer_address
 * @property string $s_customer_hand_phone
 * @property string $s_customer_home_phone
 * @property integer $i_created_date
 * @property integer $i_total_service
 * @property string $s_order_service
 * @property string $s_total_money
 * @property string $s_reason
 * @property string $s_notes
 * @property integer $i_status
 * @property interger $i_flag_sync;
 * @property integer $i_flag_delete
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class Order extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Order the static model class
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
		return 'order';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id,s_store_id', 'required'),
			array('i_created_date, i_total_service, i_status, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_customer_name, s_customer_address, s_reason, s_notes', 'length', 'max'=>255),
			array('s_customer_hand_phone, s_customer_home_phone', 'length', 'max'=>20),
			array('s_order_service, s_total_money', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, s_order_code, pk_s_id, s_store_id, s_user_id, s_customer_id, s_customer_name, s_customer_address, s_customer_hand_phone, s_customer_home_phone, i_created_date, i_total_service, s_order_service, s_total_money, s_discount_id, s_discount_name, f_discount, s_total_after_discount, i_method, s_reason, s_notes, i_status, i_flag_sync, i_flag_deleted, i_disable, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
            's_order_code' => 'Order Code',
			's_store_id' => 'Store',
			's_user_id' => 'Creators',
			's_customer_id' => 'Customer',
			's_customer_name' => 'Customer Name',
			's_customer_address' => 'Customer Address',
			's_customer_hand_phone' => 'Customer Hand Phone',
			's_customer_home_phone' => 'Customer Home Phone',
			'i_created_date' => 'Created',
			'i_total_service' => 'Total Service',
			's_order_service' => 'Order Service',
			's_total_money' => 'Total Money',
            's_discount_id'=>'Discount ID',
            's_discount_name' =>'Discount Name',
            'f_discount' => 'Discount Value', 
            's_total_after_discount' =>'Total After Discount', 
            'i_method' => 'Method',
			's_reason' => 'Reason',
			's_notes' => 'Notes',
			'i_status' => 'Status',
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
		$criteria->compare('s_store_id',Yii::app()->user->storeID);
		$criteria->compare('s_user_id',$this->s_user_id);
		$criteria->compare('s_customer_id',$this->s_customer_id);
		$criteria->compare('s_customer_name',$this->s_customer_name,true);
		$criteria->compare('s_customer_address',$this->s_customer_address,true);
		$criteria->compare('i_created_date',$this->i_created_date);
		$criteria->compare('i_status',$this->i_status);
		$criteria->compare('i_flag_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function customer(){
        return Customer::model()->find('pk_s_id = :pk_s_id and s_store_id = :s_store_id',array(':s_store_id' => isset(Yii::app()->user->storeID)?Yii::app()->user->storeID:'-1',':pk_s_id' =>$this->s_customer_id));
    }
}