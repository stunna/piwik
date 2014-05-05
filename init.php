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
$piwikBaseURL = OW::getConfig()->getValue('piwik', 'site_url');
$piwikSiteID = OW::getConfig()->getValue('piwik', 'site_id');

if ( null !== $piwikSiteID && null !== $piwikBaseURL)
{
    function piwik_add_code()
    {      
        $code = '<!-- Piwik -->
                 <script type="text/javascript">
                    var _paq = _paq || [];
                    _paq.push([\'trackPageView\']);
                    _paq.push([\'enableLinkTracking\']);
                 (function() {
                     var u=(("https:" == document.location.protocol) ? "'.rtrim(OW::getConfig()->getValue('piwik', 'site_url'),"/")."/".'" : "'.rtrim(OW::getConfig()->getValue('piwik', 'site_url'),"/")."/".'");
                     _paq.push([\'setTrackerUrl\', u+\'piwik.php\']);
                     _paq.push([\'setSiteId\', '.trim(OW::getConfig()->getValue('piwik', 'site_id')).']);
                     var d=document, g=d.createElement(\'script\'), s=d.getElementsByTagName(\'script\')[0]; g.type=\'text/javascript\';
                     g.defer=true; g.async=true; g.src=u+\'piwik.js\'; s.parentNode.insertBefore(g,s);
                 })();
                </script>
                <noscript><p><img src="'.rtrim(OW::getConfig()->getValue('piwik', 'site_url'),"/").'/piwik.php?idsite='.trim(OW::getConfig()->getValue('piwik', 'site_id')).'" style="border:0;" alt="" /></p></noscript>
                <!-- End Piwik Code -->';

        OW::getDocument()->appendBody($code);
    }
    OW::getEventManager()->bind(OW_EventManager::ON_FINALIZE, 'piwik_add_code');
}

OW::getRouter()->addRoute(new OW_Route('piwik_admin', 'admin/plugins/piwik', 'PIWIK_CTRL_Admin', 'index'));

function piwik_admin_notification( BASE_CLASS_EventCollector $event )
{
    $piwikBaseURL = OW::getConfig()->getValue('piwik', 'site_url');
    $piwikSiteID = OW::getConfig()->getValue('piwik', 'site_id');

    if ( empty($piwikBaseURL) || empty($piwikSiteID) )
    {
        $event->add(OW::getLanguage()->text('piwik', 'admin_notification_text', array('link' => OW::getRouter()->urlForRoute('piwik_admin'))));
    }
}
OW::getEventManager()->bind('admin.add_admin_notification', 'piwik_admin_notification');