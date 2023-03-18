<?php
/**
* This module helps administrators to show website notifications regarding cookies used by stores on bottom positions with links to redirect cookie policy pages, management from the back-office with multiple options and show different message based on multiple store language.
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

class AdminSfkcookiebannerControllerCore extends AdminController {

    public function __construct() {
        $this->bootstrap = true;
        $this->table = 'sfkcookiebanner';
        $this->className = 'Sfkcookiebanner';
        $this->lang = false;
        $this->addRowAction('edit');
        $this->addRowAction('delete');
        $this->context = Context::getContext();
        if (!Tools::getValue('realedit'))
            $this->deleted = false;
        $this->bulk_actions = array(
            'delete' => array(
                'text' => $this->l('Delete selected'),
                'confirm' => $this->l('Delete selected items?')
            )
        );
        $this->fields_list = array(
            'id_sfkcookiebanner' => array(
                'title' => $this->l('ID'),
                'align' => 'left',
                'width' => 'auto'
            ),
            'sfk_title' => array('title' => $this->l('Title'), 'filter_key' => 'sfk_title', 'align' => 'left', 'width' => 'auto'),
            'sfk_text' => array('title' => $this->l('Cookie Consent Banner details'), 'filter_key' => 'sfk_text', 'align' => 'left', 'width' => 'auto'),
        );

        if (!$this->ajax && !isset($this->display)) {
            $this->context->smarty->assign(array(
                'modules_dir' => _MODULE_DIR_
            ));
            $this->content .= $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'sfkcookiebanner/views/templates/admin/sfkcookiebanner.tpl');
        }

        parent::__construct();
    }

    public function renderForm() {
        $languages = Db::getInstance()->executeS('SELECT * FROM ' . _DB_PREFIX_ . 'lang WHERE active=1 ');

        $options = array(
            array(
                'id_option' => 'Banner bottom',
                'name' => 'Banner bottom'
            ),
            array(
                'id_option' => 'Banner top',
                'name' => 'Banner top'
            ),
            array(
                'id_option' => 'bottom-left',
                'name' => 'Floating left'
            ),
            array(
                'id_option' => 'bottom-right',
                'name' => 'Floating right'
            ),
            array(
                'id_option' => 'Banner top (pushdown)',
                'name' => 'Banner top (pushdown)'
            ),
        );

        $compliance_type = array(
            array(
                'id_option' => 'NULL',
                'name' => 'Just tell users that we use cookies'
            ),
            array(
                'id_option' => 'opt-out',
                'name' => 'Let users opt out of cookies (Advanced)'
            ),
            array(
                'id_option' => 'opt-in',
                'name' => 'Ask users to opt into cookies (Advanced)'
            ),
        );

        if (_PS_VERSION_ < '1.6') {
            $type = 'radio';
        } else {
            $type = 'switch';
        }

        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Cookie Consent Banner Multilingual management'),
                'image' => '../img/admin/tab-sfkcookiebanner.gif'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Title'),
                    'name' => 'sfk_title',
                    'lang' => false,
                    'size' => 33,
                    'desc' => $this->l('Invalid characters:') . ' 0-9!<>,;?=+()@#"ï¿½{}_$%:',
                    'required' => true
                ),
                array(
                    'type' => 'textarea',
                    'label' => $this->l('Cookie Consent Banner details'),
                    'name' => 'sfk_text',
                    'lang' => false,
                    'cols' => 50,
                    'rows' => 10,
                    'autoload_rte' => true,
                    'required' => true,
                    'desc' => $this->l('Cookie usage related information to be shown in bottom of the page.')
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Label "Allow Cookies" Title'),
                    'name' => 'sfk_continue_title',
                    'lang' => false,
                    'size' => 33,
                    'desc' => $this->l('Title text for label "Allow Cookies" or "Continue" or other multi-lingual text.'),
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Label "Decline" Title'),
                    'name' => 'sfk_decline_title',
                    'lang' => false,
                    'size' => 33,
                    'desc' => $this->l('Title text for label "Decline Cookies" or "Decline" or other multi-lingual text.'),
                    'required' => true
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Label "Cookies Policy Link" Title:'),
                    'name' => 'sfk_learn_title',
                    'lang' => false,
                    'size' => 33,
                    'desc' => $this->l('Title text for label "Learn More" or "Cookies Policy Link"'),
                    'required' => false
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Cookies Policy Link'),
                    'name' => 'sfk_url',
                    'lang' => false,
                    'size' => 33,
                    'desc' => $this->l('Kindly enter valid URL of cookie privacy policy page of the website.For example https://www.hrms-systems.com/cookies-policy.html'),
                    'required' => false
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Choose Position'),
                    'name' => 'sfk_position',
                    'required' => false,
                    'options' => array(
                        'query' => $options,
                        'id' => 'id_option',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Compliance Type'),
                    'name' => 'sfk_compliance_type',
                    'required' => false,
                    'desc' => $this->l('For more information visit link => https://www.osano.com/cookieconsent/download/'),
                    'options' => array(
                        'query' => $compliance_type,
                        'id' => 'id_option',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Choose Language'),
                    'name' => 'sfk_language[]',
                    'required' => false,
                    'multiple' => true,
                    'expanded' => true,
                    'desc' => $this->l('Cookie consent banner will be shown only on selected languages on front-office.'),
                    'options' => array(
                        'query' => $languages,
                        'id' => 'id_lang',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => "$type",
                    'label' => $this->l('Active:'),
                    'name' => 'sfk_status',
                    'required' => false,
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'id' => 'sfk_status_on',
                            'value' => 1,
                            'label' => $this->l('Yes')
                        ),
                        array(
                            'id' => 'sfk_status_off',
                            'value' => 0,
                            'label' => $this->l('No')
                        )
                    ),
                    'desc' => $this->l('Active or Inactive record status.')
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date'),
                    'name' => 'sfk_dates',
                    'size' => 20,
                    'search' => false,
                    'required' => false,
                    'desc' => $this->l('The date home record added/updated.')
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default'
            )
        );

        if (isset($_REQUEST['id_sfkcookiebanner'])) {
            $id_sfkcookiebanner = (trim($_REQUEST['id_sfkcookiebanner']));
        }

        if (!empty($id_sfkcookiebanner)) {
            $sfk_position = Db::getInstance()->getValue('SELECT sfk_position FROM ' . _DB_PREFIX_ . 'sfkcookiebanner WHERE 
            id_sfkcookiebanner=' . pSQL($id_sfkcookiebanner) . ' ');
            $this->fields_value['sfk_position'] = $sfk_position;

            $sfk_language = Db::getInstance()->getValue('SELECT sfk_language FROM ' . _DB_PREFIX_ . 'sfkcookiebanner WHERE 
            id_sfkcookiebanner=' . pSQL($id_sfkcookiebanner) . ' ');
            $this->fields_value['sfk_language[]'] = explode(',', $sfk_language);
        }

        return parent::renderForm();
    }

    public function postProcess() {
        $multiple_languages = array();
        $multiple_languages = Tools::getValue('sfk_language');

        $_POST['sfk_language'] = implode(',', (array) $multiple_languages);

        parent::postProcess();
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

}
