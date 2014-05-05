if (!OW::getConfig()->configExists('piwik', 'site_url')){
      OW::getConfig()->addConfig('piwik', 'site_url', null);
}

if (!OW::getConfig()->configExists('piwik', 'site_id')){
    OW::getConfig()->addConfig('piwik', 'site_id', null);
}

OW::getPluginManager()->addPluginSettingsRouteName('piwik', 'piwik_admin');
