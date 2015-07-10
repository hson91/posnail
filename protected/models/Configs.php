<?php

/**
 * This is the model class for table "configs".
 *
 * The followings are the available columns in table 'configs':
 * @property integer $id
 * @property string $title
 * @property string $alias
 * @property integer $lang_id
 * @property string $value
 * @property integer $is_textarea
 * @property integer $status
 * @property string $inserted
 * @property string $updated
 * @property integer $inserter
 * @property integer $updater
 */
class Configs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Configs the static model class
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
		return 'configs';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, alias', 'required'),
			array('is_textarea, status, inserter, updater', 'numerical', 'integerOnly'=>true),
			array('title, alias', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, alias, value, is_textarea, status, inserted, updated, inserter, updater', 'safe'),
			array('id, title, alias, value, is_textarea, status, inserted, updated, inserter, updater', 'safe', 'on'=>'search'),
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
			'title' => 'Title',
			'alias' => 'Alias',
			'value' => 'Value',
			'is_textarea' => 'Is HTML',
			'status' => 'Status',
			'inserted' => 'Created',
			'updated' => 'Updated',
			'inserter' => 'Inserter',
			'updater' => 'Updater',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('value',$this->value,true);
		$criteria->compare('is_textarea',$this->is_textarea);
		$criteria->compare('status',$this->status);
		$criteria->compare('inserted',$this->inserted,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('inserter',$this->inserter);
		$criteria->compare('updater',$this->updater);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort' => array(
                'defaultOrder' => 'updated desc',
            ),
			'pagination'=>array(
				'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			)
		));
	}
    
    public static function getConfig($alias){
        $config = Configs::model()->find('alias = :alias and status = 1', array(':alias' => $alias));
        if($config != null)
            return $config->value;
        return '';
    }
    
    public static function getConfigs(){
        //$configs = Yii::app()->db->createCommand('SELECT * FROM configs WHERE status = 1')->queryAll();
        $configs = Configs::model()->findAll('status = 1');
        $arr = array();
        if($configs != null){
            foreach($configs as $r){
                if($r->alias == 'nuumber-mobile' || $r->alias == 'number-tablets' || $r->alias == 'number-laptop'){
                    $configMobile = explode("|",$r->value);
                    if(count($configMobile) == 1){$configMobile[1] = 0;}
                    if(time() -  strtotime($r->updated)  > 86400){
                        $configMobile[0] = $configMobile[0] + $configMobile[1];
                        $r->value = $configMobile[0]." | ".$configMobile[1];
                        $r->save();
                    }
                    $arr[$r->alias] = $configMobile[0];
                }else{
                    $arr[$r->alias] = $r->value;
                }
                
            }
        }
        return $arr;
    }
    
    protected function beforeSave() {
        if ($this->isNewRecord) {
            $this->inserted = new CDbExpression('NOW()');
            $this->inserter = Yii::app()->user->id;
        }
        $this->updated = new CDbExpression('NOW()');
        $this->updater = Yii::app()->user->id;
        return true;
    }
}