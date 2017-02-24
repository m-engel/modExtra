<?php
/**
 * modExtra
 *
 * Copyright 2010 by Shaun McCormick <shaun+modextra@modx.com>
 *
 * modExtra is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * modExtra is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * modExtra; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package modextra
 */
require_once dirname(__FILE__) . '/model/modextra/modextra.class.php';
/**
 * @package modextra
 */
class IndexManagerController extends modExtraBaseManagerController {
    public static function getDefaultController() { return 'home'; }
}

abstract class modExtraBaseManagerController extends modExtraManagerController {
    /** @var modExtra $modextra */
    public $modextra;
    public function initialize() {
        $this->modextra = new modExtra($this->modx);

        $this->addCss($this->modextra->config['cssUrl'].'mgr.css');
        $this->addJavascript($this->modextra->config['jsUrl'].'mgr/modextra.js');
        $this->addHtml('<script type="text/javascript">
        Ext.onReady(function() {
            modExtra.config = '.$this->modx->toJSON($this->modextra->config).';
            modExtra.config.connector_url = "'.$this->modextra->config['connectorUrl'].'";
        });
        </script>');
        return parent::initialize();
    }
    public function getLanguageTopics() {
        return array('modextra:default');
    }
    public function checkPermissions() { return true;}

    public function activateRTE(){
        $plugin=$this->modx->getObject('modPlugin',array('name'=>'TinyMCE'));
        if(!$plugin) return false;

        $tinyPath = $this->modx->getOption('core_path').'components/tinymce/';
        $tinyProperties=$plugin->getProperties();
        require_once $tinyPath.'tinymce.class.php';
        $tiny = new TinyMCE($this->modx, $tinyProperties);

        $tinyProperties['language'] = $this->modx->getOption('cultureKey',null,$this->modx->getOption('manager_language',null,'ru'));
        $tinyProperties['cleanup'] = true;
        $tinyProperties['width'] = '100%';
        $tinyProperties['height'] = 200;

        $tinyProperties['tiny.custom_buttons1'] = 'undo,redo,separator,pastetext,search,replace,separator,cleanup,removeformat,tablecontrols,separator,modxlink,unlink,anchor,separator,image,media,separator,code';
        $tinyProperties['tiny.custom_buttons2'] = 'formatselect,separator,forecolor,backcolor,separator,bold,italic,underline,separator,strikethrough,sub,sup,separator,justifyleft,justifycenter,justifyright,justifyfull';
        $tinyProperties['tiny.custom_buttons3'] = '';

        $tiny->setProperties($tinyProperties);
        $tiny->initialize();

    }
}