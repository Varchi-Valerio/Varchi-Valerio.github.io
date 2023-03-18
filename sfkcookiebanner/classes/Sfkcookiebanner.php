<?php
/**
* This module helps administrators to show website notifications regarding cookies used by stores on bottom positions with links to redirect cookie policy pages, management from the back-office with multiple options, and show different messages based on multiple store languages.
*
* NOTICE OF LICENSE
* 
* Each copy of the software must be used for only one production website, it may be used on additional
* test servers. You are not permitted to make copies of the software without first purchasing the
* appropriate additional licenses. This license does not grant any reseller privileges.
* 
* @author    Shahab
* @copyright 2007-2022 Shahab-FK Enterprises
* @license   Prestashop Commercial Module License
*/

class SfkcookiebannerCore extends ObjectModel {

    public $sfk_title;
    public $sfk_text;
    public $sfk_url;
    public $sfk_position;
    public $sfk_compliance_type;
    public $sfk_continue_title;
    public $sfk_decline_title;
    public $sfk_learn_title;
    public $sfk_dates;
    public $sfk_status;
    public $sfk_language;

    /**
     * @see ObjectModel::$definition
     */
    public static $definition = array('table' => 'sfkcookiebanner', 'primary' => 'id_sfkcookiebanner', 'multilang' => false, 'fields' => array(
            'sfk_title' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'required' => true, 'size' => 500),
            'sfk_language' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'required' => true, 'size' => 500),
            'sfk_text' => array('type' => self::TYPE_HTML, 'lang' => false, 'validate' => 'isCleanHtml', 'required' => true, 'size' => 5000),
            'sfk_url' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isURL', 'required' => false, 'size' => 500),
            'sfk_position' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'required' => false, 'size' => 300),
            'sfk_compliance_type' => array('type' => self::TYPE_STRING, 'lang' => false, 'required' => false, 'size' => 300),
            'sfk_continue_title' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'required' => false, 'size' => 500),
            'sfk_decline_title' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'required' => false, 'size' => 500),
            'sfk_learn_title' => array('type' => self::TYPE_STRING, 'lang' => false, 'validate' => 'isString', 'required' => false, 'size' => 500),
            'sfk_status' => array('type' => self::TYPE_BOOL, 'lang' => false, 'validate' => 'isString', 'required' => false),
            'sfk_dates' => array('type' => self::TYPE_DATE, 'lang' => false, 'validate' => 'isDateFormat', 'copy_post' => false)));

    public static function getSfkcookiebanner($id_lang = null) {
        if (is_null($id_lang))
            $id_lang = Context::getContext()->language->id;
        $sfkcookiebanner = new Collection('Sfkcookiebanner', $id_lang);
        return $sfkcookiebanner;
    }

    public function __construct($id = null, $id_lang = null, $id_shop = null) {
        parent::__construct($id, $id_lang, $id_shop);
        $this->image_dir = _PS_STORE_IMG_DIR_;
    }

}
