<?php
class ApiController extends Controller{
    protected $_getData = null;
    public function init(){
        if(isset($_POST['data'])){
            $this->_getData = json_decode( $_POST['data'] );
        }
        /*
        if($this->_getData == null){
            $this->sendResponse(null,0,'Error! No data is sent to server');
            Yii::app()->end();
        } */
    }
    public function actionTest(){
       $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_code,s_name,s_address,s_hand_phone,s_home_phone,s_email,i_level, i_sync_image,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('customer')
                                ->where('i_flag_sync = 1 AND s_store_id = :storeID',array(':storeID' => $storeID))
                                ->queryAll();
        $this->sendResponse($models,1);
    }
    public function actionGetAccountByDevice(){
        $data = $this->setData($data, $this->_getData,'Error! No data is sent to server');
        $dataSendToMobile = array();
        if(!isset($data->deviceID)){
            $this->sendResponse(null,0,'DeviceID undefined');
        }
        $deviceID = $data->deviceID;
        $device = Yii::app()->db->createCommand()
                                ->select('s_deviceID,i_os_type,s_user_id,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('device')
                                ->where('s_deviceID = :s_deviceID',array(':s_deviceID' => $deviceID))
                                ->queryRow(); 
        if($device == false){
            $model = new Device;
            $model->s_deviceID = $deviceID;
            $model->i_os_type = 0;
            $model->s_user_id = null;
            $model->i_flag_sync = 1;
            $model->i_flag_deleted = 0;
            $model->i_disable = 0;
			$model->save();
            $this->sendResponse(null,1,'Create device: "'.$deviceID.'" success');
        }
		
        $dataSendToMobile['device'] = array($device);
        $manager = Yii::app()->db->createCommand()
                                ->select('*')
                                ->from('user')
                                ->where('pk_s_id = :pk_s_id',array(':pk_s_id' => $device['s_user_id']))
                                ->queryRow();
		// Update i_closest_sync
		$singleDevice = Device::model()->find('s_deviceID = :s_deviceID',array(':s_deviceID' => $deviceID));
		$singleDevice->i_sync_closest = time() + 1;
		$singleDevice->save();
        
        if($manager == false){
            $this->sendResponse($dataSendToMobile,0,'Account not found by deviceID: '.$deviceID);
        }
        $store = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_name,s_image_server,s_image_local,i_image_color,i_sync_image,s_address,s_summary,i_is_trial,i_trial_from,i_trial_to,i_lock,s_description,s_latitude,s_longitude,i_flag_sync,i_flag_deleted,i_disable,i_status,i_inserted,i_updated')
                                ->from('store')
                                ->where('pk_s_id = :pk_s_id',array(':pk_s_id' => $manager['s_store_id']))
                                ->queryRow();
        if($store == false){
            $this->sendResponse($dataSendToMobile,0,'Store not found by account: '.$manager->s_username);
        }
		
        $dataSendToMobile['store'] = array($store);
        
        $discount = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_name,f_discount,i_flag_deleted,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('discount')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['discount'] = $discount;
        $order = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_order_code,s_store_id,s_user_id,s_customer_id,s_customer_name,s_customer_address,s_customer_hand_phone,s_customer_home_phone,i_created_date,i_total_service,s_order_service,s_total_money,s_discount_id,s_discount_name,f_discount,s_total_after_discount,i_method,s_reason,s_notes,i_status,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('order')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['order'] = $order;
        $orderDetail = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_order_id,s_store_id,s_service_id,s_user_id,s_user_fullname,s_user_tell,s_user_email,s_service_name,s_service_alias,s_service_price,i_qty,s_total,f_discount,s_total_after_discount,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('order_detail')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['order_detail'] = $orderDetail;
        $users = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,i_user_role,i_shopping,i_manager,s_code,s_username,s_password,s_secret_code,i_device_count,i_device_max,s_fullname,s_address,s_image_server,s_image_local,i_image_color,i_sync_image,s_email,s_tell,s_store_alias,s_token,s_code_active,i_time_send_code_active,s_params,i_active,i_lock,i_flag_sync,i_flag_deleted,i_disable,folder_storage,i_login_closest,i_inserted,i_updated')
                                ->from('user')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['user'] = $users;
        
        $serviceType = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_parent_id,s_store_id,s_name,s_alias,s_image_server,s_image_local,i_sync_image,s_summary,s_description,s_params,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('service_type')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['service_type'] = $serviceType;
        
        $services = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_service_type_id,s_name,s_alias,s_image_server,s_image_local,i_image_color,i_sync_image,s_price,s_unit,s_summary,s_description,s_params,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('service')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['service'] = $services;
        
        $customer = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_code,s_name,s_address,s_hand_phone,s_home_phone,s_email,s_image_server,s_image_local,i_sync_image,i_level,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('customer')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['customer'] = $customer;
        
        $reference = Yii::app()->db->createCommand()
                                ->select('s_store_id,s_key,s_value,s_description,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('reference')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['reference'] = $reference;
        
        $share = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_title,s_alias,s_image_server,s_image_local,i_sync_image,s_summary,s_description,i_view,s_params,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('share')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['share'] = $share;
        
        $shareSlideShow = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_share_id,s_store_id,s_image_server,s_image_local,i_sync_image,i_flag_sync,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('share_slide_show')
                                ->where('s_store_id = :s_store_id',array(':s_store_id' => $store['pk_s_id']))
                                ->queryAll();
        $dataSendToMobile['share_slide_show'] = $shareSlideShow;
		
        $this->sendResponse($dataSendToMobile,1);
    }
    public function actionRegister(){
        $data = $this->setData($data, $this->_getData,'Error! No data is sent to server');
        if(!isset($data->device)){
            $this->sendResponse(null,0,'Device invalid');
        }
        if(!isset($data->user)){
            $this->sendResponse(null,0,'Account invalid');
        }
        $flagSave = false; 
        $device = new Device;
        
        $user = new User;
        $user->pk_s_id = '-1';
        foreach($data->user as $k => $v){
            if($user->hasAttribute($k)){
                $user->$k = $v;
            }
        }
        if($user->save()){
            $user->pk_s_id = 'SV'.$user->id;
            if($user->save()){
                $flagSave = true;
                $device->s_user_id = $user->pk_s_id;
                foreach($data->device as $k => $v){
                    if($device->hasAttribute($k)){
                        $device->$k = $v;
                    }
                }
                if($device->save()){
                    $flagSave = true;
                }else{
                    $flagSave = false;
                    $user->delete();
                }
            }
        }
        if($flagSave == true){
            $this->sendResponse(null,1,'success');
        }else{
            $this->sendResponse(null,0,'fail');
        }
    }
    public function actionSync(){
        $data = $this->_getData;
        $dataSend = array();
        $deviceID = isset($data->deviceID)?$data->deviceID:null;
        $device = Device::model()->find('s_deviceID = :s_deviceID',array(':s_deviceID' => $deviceID));
        if($device == null){
            $this->sendResponse(null,1,'Device not found');
        }
        $manager = $device->getUser();
        if($manager == null){
            $this->sendResponse($dataSendToMobile,0,'Account not found by deviceID: '.$deviceID);
        }
		
        $storeID = $manager->s_store_id;
        if($data != null){
            $dataSyncSuccess = array();
            $error = false;
            foreach( $data as $k => $v ){
                $classModel = $this->getModel( $k );
                if($classModel != null){
                    $success = array();
                    foreach( $v as $record ){
					
						$s_id = $record->pk_s_id;
						$model = $classModel::model()->findBySql("SELECT * FROM `$k` WHERE `pk_s_id` = :pk_s_id",array(':pk_s_id'=>$s_id));
						
                        if($model == null){
							$model = new $classModel;
							$model->i_flag_sync = 0;
							$model->i_updated = 0;
                        }
						
						if($model->i_updated < $record->i_updated)
						{
							foreach( $record as $krecord=>$vrecord ){
								if($model->hasAttribute($krecord)){
									$model->$krecord = $vrecord;
								} // End if
							} // End foreach
							
							$model->i_flag_sync = 0;
							if($model->hasAttribute('s_store_id')){
								$model->s_store_id = $storeID;
							}
							
							if($model->save()){
								array_push($success,array('pk_s_id' =>$record->pk_s_id));
							}else{
								$error = true;
							}
						}
                    }
                    if(count($success) > 0){
                        $dataSyncSuccess[$k] = $success;
                    }
                }
            }
        }
		
        $dataSend= $this->getDataSyncToMobile($storeID,$device->i_sync_closest);
        if(isset($dataSyncSuccess) && count($dataSyncSuccess) > 0){
           $dataSend =  array_merge_recursive($dataSend,$dataSyncSuccess);
        }
		
		
		if($dataSend != null &&
			(
				( array_key_exists('device',$dataSend) && count($dataSend['device']) > 0 ) ||
				( array_key_exists('store',$dataSend) && count($dataSend['store']) > 0 ) ||
				( array_key_exists('order',$dataSend) && count($dataSend['order']) > 0 ) ||
				( array_key_exists('order_detail',$dataSend) && count($dataSend['order_detail']) > 0 ) ||
				( array_key_exists('user',$dataSend) && count($dataSend['user']) > 0 ) ||
				( array_key_exists('service_type',$dataSend) && count($dataSend['service_type']) > 0 ) ||
				( array_key_exists('service',$dataSend) && count($dataSend['service']) > 0 ) ||
				( array_key_exists('customer',$dataSend) && count($dataSend['customer']) > 0 ) ||
				( array_key_exists('discount',$dataSend) && count($dataSend['discount']) > 0 )
			
			)
		)
		{
			$device->i_sync_closest = time() + 1;
			$device->save();
		}
		
        $this->sendResponse($dataSend,1);
    }
    public function actionSyncImage(){
        $data = $this->setData($data, $this->_getData,'Error! No data is sent to server');
        $tableName = isset($data->tableName)?$data->tableName:null;
        $idRecoed = isset($data->pk_s_id)?$data->pk_s_id:null;
        
        if($tableName == null || $idRecoed == null){
            $this->sendResponse(null,0,'Error! No data is sent to server');
            Yii::app()->end();
        }
        $modelRecord = $this->getModel($tableName);
        $model = $modelRecord::model()->find('pk_s_id = :pk_s_id',array(':pk_s_id' => $idRecoed));
        if($model == null){
            $this->sendResponse(null,0,'Error! Record with ID = '.$idRecoed .' not exist');
            Yii::app()->end();
        }
        if(isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
            $model->s_image_server = $_FILES['image']['name'];
            $pathImage = Yii::app()->basePath.'/../data/'.$tableName.'/'. $model->s_image_server;
            @move_uploaded_file($_FILES['image']['tmp_name'],$pathImage);
            
            $imgthumb = Yii::app()->phpThumb->create(Yii::app()->basePath.'/../data/'.$tableName.'/'.$model->s_image_server);
            $imgthumb->resize(240,240);
            $imgthumb->save(Yii::app()->basePath.'/../data/'.$tableName.'/240x240_'.$model->s_image_server);
            $imgthumb->resize(120,120);
            $imgthumb->save(Yii::app()->basePath.'/../data/'.$tableName.'/120x120_'.$model->s_image_server);
            $model->i_sync_image = 0;
            if(!$model->save()){
                @unlink(Yii::app()->basePath.'/../data/'.$tableName.'/'.$model->s_image_server);
                @unlink(Yii::app()->basePath.'/../data/'.$tableName.'/240x240_'.$model->s_image_server);
                @unlink(Yii::app()->basePath.'/../data/'.$tableName.'/120x120_'.$model->s_image_server);
            }
        }else{
            $this->sendResponse(null,0,'Error! File not exist');
            Yii::app()->end();
        }
    }
    public function getDataSyncToMobile($storeID,$timeSyncClosest = 0){
        $array = array();
        if(count($this->getDataCustomerSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['customer'] = $this->getDataCustomerSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataDiscountSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['discount'] = $this->getDataDiscountSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataOrderSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['order'] = $this->getDataOrderSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataOrderDetailSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['order_detail'] = $this->getDataOrderDetailSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataReferenceSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['reference'] = $this->getDataReferenceSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataServiceSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['service'] = $this->getDataServiceSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataServiceTypeSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['service_type'] = $this->getDataServiceTypeSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataShareSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['share'] = $this->getDataShareSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataShareSlideShowSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['share_slide_show'] = $this->getDataShareSlideShowSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataStoreSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['store'] = $this->getDataStoreSyncToMobile($storeID,$timeSyncClosest);
        }
        if(count($this->getDataUserSyncToMobile($storeID,$timeSyncClosest)) > 0){
            $array['user'] = $this->getDataUserSyncToMobile($storeID,$timeSyncClosest);
        }
        return $array;
    }
    public function getDataCustomerSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_code,s_name,s_address,s_hand_phone,s_home_phone,s_email,i_level, i_sync_image,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('customer')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataDiscountSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_name,f_discount,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('discount')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataOrderSyncToMobile($storeID,$timeSyncClosest){
        
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_order_code,s_store_id,s_store_id,s_customer_id,s_customer_name,s_customer_address,s_customer_hand_phone,s_customer_home_phone,i_created_date,i_total_service,s_order_service,s_total_money,s_discount_id,s_discount_name,f_discount,s_total_after_discount,i_method,s_reason,s_notes,i_status,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('order')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataOrderDetailSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('s_order_id,s_store_id,s_service_id,s_store_id,s_user_id,s_user_fullname,s_user_tell,s_user_email,s_service_name,s_service_alias,s_service_price,i_qty,s_total,f_discount,s_total_after_discount,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('order_detail')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataReferenceSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('s_store_id,s_key,s_value,s_description,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('reference')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataServiceSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_service_type_id,s_name,s_alias,i_image_color,i_sync_image,s_price,s_unit,s_summary,s_description,s_params,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('service')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataServiceTypeSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select( 'pk_s_id,s_parent_id,s_store_id,s_name,s_alias,s_summary,s_description,s_params,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('service_type')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataShareSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,s_title,s_alias,s_summary,s_description,i_view,s_params,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('share')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataShareSlideShowSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_share_id,s_store_id,i_flag_deleted,i_disable,i_inserted,i_updated')
                                ->from('share_slide_show')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataStoreSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_name,i_image_color,s_address,s_summary,i_is_trial,i_trial_from,i_trial_to,i_lock,s_description,s_latitude,s_longitude,i_flag_deleted,i_disable,i_status,i_inserted,i_updated')
                                ->from('store')
                                ->where('i_updated >= :i_updated AND pk_s_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getDataUserSyncToMobile($storeID,$timeSyncClosest){
        $models = Yii::app()->db->createCommand()
                                ->select('pk_s_id,s_store_id,i_user_role,i_shopping,i_manager,s_code,s_username,s_password,s_secret_code,i_device_count,i_device_max,s_fullname,s_address,i_image_color,s_email,s_tell,s_store_alias,s_token,s_code_active,i_time_send_code_active,s_params,i_active,i_lock,i_flag_deleted,i_disable,folder_storage,i_login_closest,i_inserted,i_updated')
                                ->from('user')
                                ->where('i_updated >= :i_updated AND s_store_id = :storeID',array(':i_updated' => $timeSyncClosest,':storeID' => $storeID))
                                ->queryAll();
        return $models;
    }
    public function getModel($tableName = ''){
        switch($tableName){
            case "customer":
                return 'Customer';
                break;
            case "discount":
                return 'Discount';
                break;
            case "order":
                return 'Order';
                break;
            case "order_detail":
                return 'OrderDetail';
                break;
            case "reference":
                return 'Reference';
                break;
            case "service":
                return 'Service';
                break;
            case "service_type":
                return 'ServiceType';
                break;
            case "share":
                return 'Share';
                break;
            case "share_slide_show":
                return 'ShareSlideShow';
                break;
            case "store":
                return 'Store';
                break;
            case "user":
                return 'User';
                break;
            default:
                return null;
                break;
        }
        return null;
    }
    public function setData(&$key,$value = null,$messageIfNull = ''){
        if(!isset($value) || $value == null){
            $this->sendResponse(null,0,$messageIfNull);
            Yii::app()->end();
        }
        return $key = $value;
    }
    public function sendResponse($data = null,$i_status = null,$message = null,$params = null){
        $array = array();
        if($data != null){$array['data'] = $data;}
        if($i_status != null){$array['status'] = $i_status;}
        if($message != null){$array['message'] = $message;}
        echo json_encode($array);
        exit;
    }
}