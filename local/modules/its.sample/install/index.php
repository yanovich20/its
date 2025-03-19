<?php

use Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Loader;
use Bitrix\Main\EventManager;
use ITS\TitleDescriptionTable;

class its_sample extends CModule {
    public $MODULE_ID = 'its.sample';
    public $MODULE_NAME;
    public $MODULE_DESCRIPTION;
    public $MODULE_VERSION;
    public $MODULE_VERSION_DATE;
    public $PARTNER_NAME;
    public $PARTNER_URI;

    public function __construct()
    {
        $arModuleVersion = [];
        include __DIR__ . '/version.php';

        if (is_array($arModuleVersion)) {
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        }

        $this->MODULE_ID = 'its.sample';
        $this->MODULE_NAME = Loc::GetMessage("its.sample:MODULE_NAME");
        $this->MODULE_DESCRIPTION = Loc::GetMessage("its.sample:MODULE_DESC");
        $this->MODULE_GROUP_RIGHTS = 'N';

        $this->PARTNER_NAME = Loc::GetMessage("its.sample:PARTNER_NAME");
        $this->PARTNER_URI = Loc::GetMessage("its.sample:PARTNER_URI");
    }

    public function doUninstall()
    {
        if (!$this->UnInstallDB()) {
            return false;
        }

        $this->UnInstallEvents();
        $this->UnInstallFiles();

        ModuleManager::unRegisterModule($this->MODULE_ID);
        return true;
    }

    public function doInstall()
    {
        ModuleManager::registerModule($this->MODULE_ID);

        if (!$this->InstallDB()) {
            return false;
        }

        if (!$this->InstallEvents()) {
            $this->UninstallDB();
            return false;
        }

        if (!$this->InstallFiles()) {
            $this->UninstallDB();
            $this->UninstallFiles();
            return false;
        }

        return true;
    }

    public function InstallDB()
    {
        $connection = Application::getConnection();
        $isExist = $connection->isTableExists("title_description");
        if(!$isExist)
        {
            Loader::includeModule($this->MODULE_ID);
            TitleDescriptionTable::getEntity()->createDbTable();
        }
        return true;
    }

    public function UninstallDB()
    {
        $connection = Application::getConnection();
        $isExist = $connection->isTableExists("title_description");
        if($isExist)
        {
            $result = $connection->dropTable("title_description");
        }
        //return $result;
        return true;
    }

    public function InstallEvents()
    {
        $eventManager = EventManager::getInstance(); 
        $eventManager->registerEventHandler("main","onProlog","its.sample","\\ITS\\PrologEventHandler","onPrologEventHandler");
        $eventManager->registerEventHandler("main","onEpilog","its.sample","\\ITS\\EpilogEventHandler","onEpilogEventHandler");
        return true;
    }

    public function UninstallEvents()
    {
        $eventManager = EventManager::getInstance(); 
        $eventManager->unRegisterEventHandler("main","onProlog","its.sample","\\ITS\\PrologEventHandler","onPrologEventHandler");
        $eventManager->unRegisterEventHandler("main","onEpilog","its.sample","\\ITS\\EpilogEventHandler","onEpilogEventHandler");
        return true;
    }

    public function InstallFiles()
    {
        return true;
    }

    public function UninstallFiles()
    {
        return true;
    }
}
