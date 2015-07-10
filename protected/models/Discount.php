<?php

/**
 * This is the model class for table "discount".
 *
 * The followings are the available columns in table 'discount':
 * @property integer $id
 * @property integer $pk_s_id
 * @property string $s_store_id
 * @property string $s_name
 * @property double $f_discount
 * @property integer $i_flag_deleted
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class Discount extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Discount the static model class
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
		return 'discount';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, pk_s_id, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('f_discount', 'numerical'),
			array('s_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, pk_s_id, s_store_id, s_name, f_discount, i_flag_deleted, i_disable, i_flag_sync, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
			'pk_s_id' => 'Pk S',
            's_store_id' => 'Store ID',
			's_name' => 'S Name',
			'f_discount' => 'F Discount',
			'i_flag_deleted' => 'I Flag Deleted',
			'i_disable' => 'I Disable',
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
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('f_discount',$this->f_discount);
		$criteria->compare('i_flag_deleted',$this->i_flag_deleted);
		$criteria->compare('i_disable',$this->i_disable);
		$criteria->compare('i_inserted',$this->i_inserted);
		$criteria->compare('i_updated',$this->i_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}