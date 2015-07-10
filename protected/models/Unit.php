<?php

/**
 * This is the model class for table "unit".
 *
 * The followings are the available columns in table 'unit':
 * @property integer $id
 * @property string $s_alias
 * @property string $s_name
 * @property interger $i_flag_sync
 * @property integer $i_flag_delete
 * @property integer $i_disable
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class Unit extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Unit the static model class
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
		return 'unit';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('i_flag_delete, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_alias', 'length', 'max'=>10),
			array('s_name', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, s_alias, s_name, i_flag_sync, i_flag_delete, i_disable, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
			's_alias' => 'Alias',
			's_name' => 'Name',
			'i_flag_delete' => 'Flag Delete',
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
		$criteria->compare('s_alias',$this->s_alias,true);
		$criteria->compare('s_name',$this->s_name,true);
		$criteria->compare('i_flag_delete',$this->i_flag_delete);
		$criteria->compare('i_disable',$this->i_disable);
		$criteria->compare('i_inserted',$this->i_inserted);
		$criteria->compare('i_updated',$this->i_updated);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}