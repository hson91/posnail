<?php
class Controller extends CController
{
	public $layout='main';
    public $configs = array();
    public $breadcrumbs;
    public $seo_keywords = null;
    public $seo_description = null;
    public $link_canonical = null;
    public $metaImage = null;
    public $active = null;
    public $is_home = false;
    public $guestLogin = null;
    public $slides = null;
    public $http = 'http://';
    public function init() {
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        parent::init();
        $this->pageTitle = "POS NAIL";
        if(Yii::app()->session['guestLogin']){
            $this->guestLogin = Yii::app()->session['guestLogin'];
        }
        $this->configs = Configs::getConfigs();
    }
    
    protected function beforeRender($view) {
        /*
        $seoUrl = SeoUrls::model()->find('url = :url', array(':url'=>Yii::app()->request->url));
        if($seoUrl){
            if($seoUrl->seo_title != ''){
                $this->pageTitle = $seoUrl->seo_title;
            }
            if($seoUrl->seo_keywords != ''){
                $this->seo_keywords = $seoUrl->seo_keywords;
            }
            if($seoUrl->seo_description != ''){
                $this->seo_description = $seoUrl->seo_description;
            }
            if($seoUrl->image != ''){
                $this->metaImage = $this->http.$_SERVER['HTTP_HOST']."/images/seourls/".$seoUrl->image;    
            }
            if($seoUrl->head_rel_canonical != ''){
                $this->link_canonical = $seoUrl->head_rel_canonical;
            }
        }
        Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'title');
        Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'og:title');
        Yii::app()->clientScript->registerMetaTag($this->pageTitle, 'DC:title');
        if ($this->seo_description != null){
            Yii::app()->clientScript->registerMetaTag($this->seo_description, 'description');
            Yii::app()->clientScript->registerMetaTag($this->seo_description, 'og:description');
        }
        if ($this->seo_keywords != null){
            Yii::app()->clientScript->registerMetaTag($this->seo_keywords, 'keywords');
        }
        Yii::app()->clientScript->registerMetaTag($this->http.$_SERVER['HTTP_HOST'].Yii::app()->request->url, 'og:url');
        if($this->metaImage == null){
            $this->metaImage = $this->http.$_SERVER['HTTP_HOST']."/images/websites/logo_itech.png";    
        }
        Yii::app()->clientScript->registerMetaTag($this->metaImage, 'og:image'); */
        return true;
    }

    protected function afterRender($view, &$output) {
        parent::afterRender($view,$output);
        return true;
    }
}