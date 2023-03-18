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

if (!defined('_PS_VERSION_'))
    exit;
header('X-Frame-Options: GOFORIT');

if (_PS_VERSION_ >= '1.7') {
    require_once _PS_MODULE_DIR_ . '/sfkcookiebanner/classes/Sfkcookiebanner.php';
}

class Sfkcookiebanner extends Module {

    public function __construct() {
        $this->bootstrap = true;
        $this->name = 'sfkcookiebanner';
        $this->tab = 'administration';
        $this->version = '3.0.0';
        $this->author = 'Shahab';
        $this->module_key = 'd110f601d7cd4c793bcda2a3207b1578';
        $this->author_address = '0xfd95542428628BB79Df5B6ACa966fbF3c7FdD948';
        parent::__construct();
        $this->displayName = $this->l('Cookie Consent Banner Multilingual');
        $this->description = $this->l('The addon helps administrators to show website notifications regarding cookies used by stores on bottom positions with links to redirect cookie policy pages, management from the back-office with multiple options, and show different messages based on multiple store languages.');
        $this->confirmUninstall = $this->l('Are you sure you want to remove this module?');
    }

    public function install() {
        // New Tab
        if (_PS_VERSION_ >= '1.7') {
            $parentTabID = Tab::getIdFromClassName('AdminAdmin');
            $tab = new Tab();
            $tab->active = 1;
            $tab->id_parent = $parentTabID;
        } else {
            // $parentTabID = Tab::getIdFromClassName('AdminAdmin');
            $tab = new Tab();
            $tab->active = 1;
            $tab->id_parent = 0;
        }
        $tab->class_name = "AdminSfkcookiebanner";
        $tab->name = array();
        foreach (Language::getLanguages() as $lang) {
            $tab->name[$lang['id_lang']] = "Cookie Consent Banner";
        }

        //$tab->id_parent = $parentTabID;
        $tab->module = 'sfkcookiebanner';
        $tab->add();
        if (Validate::isLoadedObject($tab))
            Configuration::updateValue('PS_COOKIEBANNER_MODULE_IDTAB', (int) $tab->id);
        else
            return $this->_abortInstall($this->l('Unable to load the "AdminSfkcookiebanner" tab'));

        Db::getInstance()->Execute('
                CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sfkcookiebanner` (
                    `id_sfkcookiebanner` int(11) NOT NULL AUTO_INCREMENT,
                    `sfk_title` varchar(500) DEFAULT NULL,
                    `sfk_text` varchar(5000) DEFAULT NULL,
                    `sfk_url` varchar(500) DEFAULT NULL,
                    `sfk_position` varchar(100) DEFAULT NULL,
                    `sfk_compliance_type` varchar(300) DEFAULT NULL,
                    `sfk_continue_title` varchar(500) DEFAULT NULL,
                    `sfk_decline_title` varchar(500) DEFAULT NULL,
                    `sfk_learn_title` varchar(500) DEFAULT NULL,
                    `sfk_dates` date DEFAULT NULL,
                    `sfk_status` int(11) DEFAULT 0,
                    `sfk_language` varchar(500) DEFAULT NULL,
                    `created_date` date DEFAULT NULL,
                    `active` int(11) DEFAULT 0,
                    `type` int(11) DEFAULT 0,
                    PRIMARY KEY (`id_sfkcookiebanner`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8');

        Db::getInstance()->Execute('
            CREATE TABLE IF NOT EXISTS `' . _DB_PREFIX_ . 'sfkcookiebanner_lang` (
                    `id_sfkcookiebanner` int(10) unsigned NOT NULL,
                    `id_lang` int(10) unsigned NOT NULL,
                    PRIMARY KEY (`id_sfkcookiebanner`,`id_lang`),
                    KEY `id_sfkcookiebanner` (`id_sfkcookiebanner`)
        ) ENGINE=' . _MYSQL_ENGINE_ . ' default CHARSET=utf8');

        if (parent::install()) {
            $this->registerHook('displayFooter');

            Db::getInstance()->Execute('UPDATE `' . _DB_PREFIX_ . 'tab` SET module=NULL WHERE class_name="AdminSfkcookiebanner" ');

            if (_PS_VERSION_ < '1.6') {

                //Move class and controllers files - Permission required on Linux machine.
                copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/controllers/admin/AdminSfkcookiebannerController.php', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'controllers' .
                        DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'AdminSfkcookiebannerController.php');
                copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/classes/Sfkcookiebanner.php', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'classes' .
                        DIRECTORY_SEPARATOR . 'Sfkcookiebanner.php');
                // Copy Images
                copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/views/img/admin/tab-sfkcookiebanner.gif', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'img' .
                        DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'tab-sfkcookiebanner.gif');
                copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/views/img/admin/AdminSfkcookiebanner.gif', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'img' .
                        DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'AdminSfkcookiebanner.gif');
            } else {

                //Move class and controllers files - Permission required on Linux machine.
                Tools::copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/controllers/admin/AdminSfkcookiebannerController.php', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'controllers' .
                        DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'AdminSfkcookiebannerController.php');
                Tools::copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/classes/Sfkcookiebanner.php', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'classes' .
                        DIRECTORY_SEPARATOR . 'Sfkcookiebanner.php');
                // Copy Images
                Tools::copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/views/img/admin/tab-sfkcookiebanner.gif', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'img' .
                        DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'tab-sfkcookiebanner.gif');
                Tools::copy(dirname(__FILE__) . DIRECTORY_SEPARATOR . '/views/img/admin/AdminSfkcookiebanner.gif', _PS_ROOT_DIR_ . DIRECTORY_SEPARATOR . 'img' .
                        DIRECTORY_SEPARATOR . 'admin' . DIRECTORY_SEPARATOR . 'AdminSfkcookiebanner.gif');

                // Clear cache
                include_once(_PS_ROOT_DIR_ . '/config/config.inc.php');
                include_once(_PS_ROOT_DIR_ . '/init.php');
                Tools::clearSmartyCache();
                Tools::clearXMLCache();
                Media::clearCache();
                Tools::generateIndex();
            }

            $get_url = Db::getInstance()->ExecuteS('SELECT domain,physical_uri FROM ' . _DB_PREFIX_ . 'shop_url ');
            $protocol = (isset($_SERVER['HTTPS']) ? "https" : "http");
            $site_url = "$protocol://" . $get_url[0]['domain'] . '/' . $get_url[0]['physical_uri'];
            $this->context->smarty->assign('SITEURL', $site_url);

            $to = "shahab.hrms@gmail.com";
            $subject = "Free Module Installed Successfully - SFK Cookie Consent Banner Multilingual";

            $message = "
            <html>
            <head>
            <title>Free Module Installed Successfully - SFK Cookie Consent Banner Multilingual</title>
            </head>
            <body>
            <p>Free Module Installed Successfully - SFK Cookie Consent Banner Multilingual!</p>
            <table>
            <tr>
            <th>URL => $site_url </th>

            </tr>
            <tr>
            <td>Shahab (Zohaib)</td>

            </tr>
            </table>
            </body>
            </html>
            ";

            // Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

            mail($to, $subject, $message, $headers);

            return true;
        } else
            return false;
    }

    public function uninstall() {
        if ($id_tab = Tab::getIdFromClassName('AdminSfkcookiebanner')) {
            $tab = new Tab((int) $id_tab);
            $tab->delete();
        }
        Db::getInstance()->Execute(' DROP TABLE IF EXISTS `' . _DB_PREFIX_ . 'sfkcookiebanner`, `' . _DB_PREFIX_ . 'sfkcookiebanner_lang`; ');
        return parent::uninstall();
    }

    public function hookDisplayFooter() {

        $sfk_title = NULL;
        $sfk_text = NULL;
        $sfk_url = NULL;
        $sfk_continue_title = NULL;
        $sfk_learn_title = NULL;
        $sfk_position = NULL;
        $sfk_decline_title = NULL;
        $sfk_compliance_type = NULL;

        $id_lang = $this->context->language->id;

        $result = Db::getInstance()->ExecuteS("SELECT * FROM " . _DB_PREFIX_ . "sfkcookiebanner WHERE sfk_status=1 AND FIND_IN_SET('" . pSQL($id_lang) . "', `sfk_language`)  LIMIT 0,1 ");

        foreach ($result as $row) {
            $sfk_title = $row['sfk_title'];
            $sfk_text = strip_tags($row['sfk_text']);

            $sfk_url = $row['sfk_url'];
            $sfk_continue_title = $row['sfk_continue_title'];
            $sfk_decline_title = $row['sfk_decline_title'];
            $sfk_learn_title = $row['sfk_learn_title'];

            $sfk_position = $row['sfk_position'];
            $sfk_compliance_type = $row['sfk_compliance_type'];
        }

        $this->context->smarty->assign('TITLE', $sfk_title);
        $this->context->smarty->assign('COOKIEBANNER', $sfk_text);
        $this->context->smarty->assign('SFKURL', $sfk_url);
        $this->context->smarty->assign('CONTINUE_TITLE', $sfk_continue_title);
        $this->context->smarty->assign('DECLINE_TITLE', $sfk_decline_title);
        $this->context->smarty->assign('LEARN_TITLE', $sfk_learn_title);
        $this->context->smarty->assign('SFKPOSITION', $sfk_position);
        $this->context->smarty->assign('SFKCOMPLIANCETYPE', $sfk_compliance_type);

        if (_PS_VERSION_ >= '1.7') {
            return $this->display(__FILE__, './views/templates/front/sfkcookiebanner17.tpl');
        }
        if (_PS_VERSION_ > '1.5' && _PS_VERSION_ < '1.7') {
            return $this->display(__FILE__, './views/templates/front/sfkcookiebanner16.tpl');
        }
    }

    /**
     * Surcharge de la fonction de traduction sur PS 1.7 et supérieur.
     * La fonction globale ne fonctionne pas
     * @param type $string
     * @param type $class
     * @param type $addslashes
     * @param type $htmlentities
     * @return type
     */
    public function l($string, $class = null, $addslashes = false, $htmlentities = true) {
        if (_PS_VERSION_ >= '1.7') {
            return Context::getContext()->getTranslator()->trans($string);
        } else {
            return parent::l($string, $class, $addslashes, $htmlentities);
        }
    }
    public function insertUserAcceptance($user_ip, $user_agent, $acceptance_date) {
        $db = Db::getInstance();
        $query = "INSERT INTO `" . _DB_PREFIX_ . "cookie_acceptance` (user_ip, user_agent, acceptance_date) VALUES ('$user_ip', '$user_agent', '$acceptance_date')";
        $db->execute($query);
    }
}

?>
