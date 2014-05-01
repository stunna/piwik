<?php
/**
 * This software is intended for use with Oxwall Free Community Software http://www.oxwall.org/ and is
 * licensed under The BSD license.

 * ---
 * Copyright (c) 2011, Oxwall Foundation
 * All rights reserved.

 * Redistribution and use in source and binary forms, with or without modification, are permitted provided that the
 * following conditions are met:
 *
 *  - Redistributions of source code must retain the above copyright notice, this list of conditions and
 *  the following disclaimer.
 *
 *  - Redistributions in binary form must reproduce the above copyright notice, this list of conditions and
 *  the following disclaimer in the documentation and/or other materials provided with the distribution.
 *
 *  - Neither the name of the Oxwall Foundation nor the names of its contributors may be used to endorse or promote products
 *  derived from this software without specific prior written permission.

 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES,
 * INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR
 * PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
 * PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED
 * AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

class PIWIK_CTRL_Admin extends ADMIN_CTRL_Abstract
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->setPageHeading(OW::getLanguage()->text('piwik', 'admin_index_heading'));
        $this->setPageHeadingIconClass('ow_ic_gear_wheel');

        $form = new Form('piwik_settings');
        $element = new TextField('site_id');
        $form->addElement($element);
        $element1 = new TextField('site_url');
        $form->addElement($element1);
        $submit = new Submit('submit');
        $submit->setValue(OW::getLanguage()->text('admin', 'save_btn_label'));
        $form->addElement($submit);

        if ( OW::getRequest()->isPost() && $form->isValid($_POST) )
        {
            $data = $form->getValues();
            if ( !empty($data['site_id']) && strlen(trim($data['site_id'])) > 0 )
            {
                OW::getConfig()->saveConfig('piwik', 'site_id', trim($data['site_id']));
                OW::getFeedback()->info(OW::getLanguage()->text('piwik', 'admin_index_site_id_save_success_message'));
            }
            else
            {
                OW::getFeedback()->error(OW::getLanguage()->text('piwik', 'admin_index_site_id_save_error_message'));
            }
            
            if ( !empty($data['site_url']) && strlen(trim($data['site_url'])) > 0 )
            {
                OW::getConfig()->saveConfig('piwik', 'site_url', trim($data['site_url']));
                OW::getFeedback()->info(OW::getLanguage()->text('piwik', 'admin_index_site_url_save_success_message'));
            }
            else
            {
                OW::getFeedback()->error(OW::getLanguage()->text('piwik', 'admin_index_site_url_save_error_message'));
            }

            $this->redirect();
        }

        $element->setValue(OW::getConfig()->getValue('piwik', 'site_id'));
        $element1->setValue(OW::getConfig()->getValue('piwik', 'site_url'));
        $this->addForm($form);
    }
}