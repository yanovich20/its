<?php
namespace ITS;

use Bitrix\Main\Page\Asset;
use Bitrix\Main\UI\Extension;
use Bitrix\Main\Diag\Debug;
use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\UserGroupTable;

class PrologEventHandler{
    public static function onPrologEventHandler(){
        global $APPLICATION;
        try{
            $userId = CurrentUser::get()->getId();
            $userContentEditor = UserGroupTable::getList(array(
                'filter' => array('USER_ID'=>$userId,'GROUP.ACTIVE'=>'Y',"GROUP.STRING_ID"=>"content_editor"),
                'select' => array('GROUP_ID','GROUP_CODE'=>'GROUP.STRING_ID'), // выбираем идентификатор группы и символьный код группы
            ))->fetch();
            if(empty($userContentEditor))
                return;
            Asset::getInstance()->addJs("/local/modules/its.sample/lib/js/script.js");
            Asset::getInstance()->addCss("/local/modules/its.sample/lib/css/styles.css");
            Extension::load("ui.dialogs.messagebox");
        }
        catch(\Throwable $e)
        {
            Debug::writeToFile($e->getMessage(),"error","/local/debug.log");
        }
    }
}