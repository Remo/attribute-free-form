<?php

namespace Concrete\Package\AttributeFreeForm;

use Concrete\Core\Backup\ContentImporter,
    Package;

class Controller extends Package
{
    protected $pkgHandle = 'attribute_free_form';
    protected $appVersionRequired = '5.7.5';
    protected $pkgVersion = '0.9.0';

    public function getPackageName()
    {
        return t('Free Form attribute');
    }

    public function getPackageDescription()
    {
        return t('Installs a customizable free form attribute');
    }

    protected function installXmlContent()
    {
        $pkg = Package::getByHandle($this->pkgHandle);

        $ci = new ContentImporter();
        $ci->importContentFile($pkg->getPackagePath() . '/install.xml');
    }

    public function install()
    {
        parent::install();

        $this->installXmlContent();
    }

    public function upgrade()
    {
        parent::upgrade();

        $this->installXmlContent();
    }

}