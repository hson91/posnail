<?php 
class MYModel extends CActiveRecord{
    
    protected $_oldData;
    public function defaultScope(){
        $condition = '';
        if($this->hasAttribute('i_flag_deleted')){
            $condition .= ' i_flag_deleted = 0 ';
        }
        return array(
            'condition'=>$condition,
            'order'=>($this->hasAttribute('i_updated'))?"i_updated DESC":"id DESC",
        );
    }
    public function beforeFind(){
        $this->_oldData = $this->attributes;
        return parent::afterFind();
    }
    public function beforeSave(){
        if($this->isNewRecord && $this->hasAttribute('i_inserted')){
            $this->i_inserted = time();
        }
        if($this->hasAttribute('i_updated'))
        $this->i_updated = time();
        return true;
    }
    public function beforeDelete(){
        return true;
    }
}
?>