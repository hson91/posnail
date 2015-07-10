<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $pk_s_id
 * @property integer $s_store_id
 * @property integer $i_user_role
 * @property string $s_code
 * @property string $s_username
 * @property string $s_password
 * @property string $s_secret_code
 * @property integer $i_device_count
 * @property integer $i_device_max
 * @property string $s_fullname
 * @property string $s_address
 * @property string $s_image
 * @property string $s_email
 * @property string $s_tell
 * @property string $s_store_alias
 * @property string $s_token
 * @property string $s_code_active
 * @property integer $i_time_send_code_active
 * @property string $s_params
 * @property integer $i_active
 * @property integer $i_lock
 * @property interger $i_flag_sync;
 * @property integer $i_flag_deleted
 * @property integer $i_disable
 * @property integer $i_login_closest
 * @property integer $i_inserted
 * @property integer $i_updated
 */
class User extends MYModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
    public $store;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
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
			array('i_device_count, i_device_max, i_time_send_code_active, i_active, i_lock, i_flag_deleted, i_disable, i_inserted, i_updated', 'numerical', 'integerOnly'=>true),
			array('s_code, s_username, s_password, s_fullname, s_address, s_email, s_token', 'length', 'max'=>255),
			array('s_secret_code', 'length', 'max'=>20),
			array('s_tell', 'length', 'max'=>50),
			array('s_store_alias', 'length', 'max'=>100),
			array('s_code_active', 'length', 'max'=>10),
			array('s_params', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
            array('id, pk_s_id, s_store_id, i_user_role, i_shopping, i_manager, s_code, s_username, s_password, s_secret_code, i_device_count, i_device_max, s_fullname, s_address, s_image_server, s_image_local, s_email, s_tell, s_store_alias, s_token, s_code_active, i_time_send_code_active, s_params, i_active, i_lock, i_flag_sync, i_flag_deleted, i_disable, folder_storage, i_login_closest, i_inserted, i_updated', 'safe'),
			array('id, pk_s_id, s_store_id, i_user_role, i_shopping, i_manager, s_code, s_username, s_password, s_secret_code, i_device_count, i_device_max, s_fullname, s_address, s_image_server, s_image_local, s_email, s_tell, s_store_alias, s_token, s_code_active, i_time_send_code_active, s_params, i_active, i_lock, i_flag_sync, i_flag_deleted, i_disable, folder_storage, i_login_closest, i_inserted, i_updated', 'safe', 'on'=>'search'),
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
            'role' => array(self::BELONGS_TO, 'Roles', 'i_user_role'),
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
			'i_user_role' => 'Account Type',
            'i_shopping' => 'Intended For',
            'i_manager' => 'Is Manager',
			's_code' => 'User Code',
			's_username' => 'Username',
			's_password' => 'Password',
			's_secret_code' => 'Secret Code',
			'i_device_count' => 'Device Count',
			'i_device_max' => 'Device Max',
			's_fullname' => 'Fullname',
			's_address' => 'Address',
			's_image_server' => 'Image',
            's_image_local' => 'Image',
			's_email' => 'Email',
			's_tell' => 'Tell',
			's_store_alias' => 'Store Alias',
			's_token' => 'Token',
			's_code_active' => 'Code Active',
			'i_time_send_code_active' => 'Time Send Code Active',
			's_params' => 'Params',
			'i_active' => 'Active',
			'i_lock' => 'Lock',
			'i_flag_deleted' => 'Flag Deleted',
			'i_disable' => 'Disable',
            'i_login_closest' => 'Login Closest',
            'folder_storage' => 'Folder Storage',
			'i_inserted' => 'Inserted',
			'i_updated' => 'Updated',
		);
	}
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($params = array())
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
        
        $is_manager = isset($params['is_manager'])?intval($params['is_manager']):null;
        $is_shopping = isset($params['is_shopping'])?intval($params['is_shopping']):1;
        $store_id = isset($params['store_id'])?$params['store_id']:null;
        
		$criteria=new CDbCriteria;
        
		$criteria->compare('t.id',$this->id);
		$criteria->compare('t.pk_s_id',$this->pk_s_id);
		$criteria->compare('t.s_store_id',$store_id);
        $criteria->compare('t.i_shopping',$is_shopping);
        $criteria->compare('t.i_manager',$is_manager);
		$criteria->compare('t.i_user_role',$this->i_user_role);
		$criteria->compare('t.s_code',$this->s_code,true);
		$criteria->compare('t.s_username',$this->s_username,true);
		$criteria->compare('t.s_fullname',$this->s_fullname,true);
		$criteria->compare('t.s_address',$this->s_address,true);
		$criteria->compare('t.s_email',$this->s_email,true);
		$criteria->compare('t.s_tell',$this->s_tell,true);
		$criteria->compare('t.i_active',$this->i_active);
		$criteria->compare('t.i_lock',$this->i_lock);
		$criteria->compare('t.i_disable',$this->i_disable);
        $criteria->compare('t.i_flag_deleted',0);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function store(){
        return Store::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id' => $this->s_store_id));
    }
    public function status(){
        $status = '';
        if($this->i_active == 1){
            if($this->i_disable == 1){
                if($this->i_lock > 0){
                    $status = '<a class="status-lock-limit" title="LOCK TO '.date("Y-m-d H:i:s",$this->i_lock).'" >Lock</a>';
                }else{
                    $status = '<a class="status-lock-unlimit">Lock unlimit<a>';
                }
            }else{
                $status = '<a class="status-active">Activate<a>';
            }
        }else{
            $status = '<a class="status-inactive">InActivate<a>';
        }
        return $status;
    }
    public function randomString($string, $length){
        $str = '';
        for($i = 0; $i< $length - 1; $i++){
            $str .= $string[rand(0, strlen($string) -1)];
        }
        return $str;
    }
    public function secretCode(){
        $charNormal = 'qwertyuioplkjhgfdsazxcvbnm';
        $charSpecial = ',;:!?.$-+&@_+;.&?$-!,';
        $strSecret = '$_'.rand(0,9);
        $strSecret .= $this->randomString($charNormal,3).$this->randomString($charSpecial,3).$this->randomString($charNormal,3).$this->randomString($charSpecial,3).'#';
        return $strSecret;
    }
    public function randomPassword(){
        $strRandom = 'qwe1r2t3y4u5i6o7p8l9k7j6h5g4f3d2s1a3z5x7c8v7b9nm';
        $password = $this->randomString($strRandom,8).$this->s_secret_code;
        return sha1($this->s_secret_code.sha1($password));
    }
    public function passwordVerify($password){
        $tmp = sha1($this->s_secret_code.sha1($password.$this->s_secret_code));
        if($this->s_password === $tmp){
            return true;
        }
        return false;
    }
    /*
    public function hasFolder($folder){
        $path = Yii::app()->basePath.'/../data/'.$folder;
        if(is_dir($path)){
            return false;
        }
        return true;
    }
    public function createFolder(){
        $folder = '';
        if($this->s_username != ''){
            $folder = substr($this->s_username,0,5);
        }else{
            $folder = substr($this->s_email,0,5);
        }
        $folder .= $this->i_user_role.rand(111,555);
        if($this->hasFolder($folder) == true){
            if(mkdir($folder,0777)){
                return $folder;
            }else{
                return $this->createFolder();
            }
        }else{
            return $this->createFolder();
        }
    }
    
    public function deleteFolder($folder){
        $path = Yii::app()->basePath.'/../data/'.$folder;
        if($handle = opendir($path)){
            while(false !== ($item = readdir($handle))){
                if($item != "." && $item != ".."){
                    if(is_dir($path.'/'.$item)){
                        $this->deleteFolder($path.'/'.$item);
                    }else{
                        unlink($path.'/'.$item);
                    }
                }
            }
            closedir($handle);
        }
        rmdir($path);
    } */
    public function getImage(){
        return Yii::app()->request->getBaseUrl(true).'/data/'.$this->folder.'/users/'.$this->s_image_server;
    }
}
