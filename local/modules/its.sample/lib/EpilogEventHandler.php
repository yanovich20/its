<?php
namespace ITS;

use Bitrix\Main\Context;
use Bitrix\Main\Web\Uri;

class EpilogEventHandler
{
    public static function onEpilogEventHandler()
    {
        global $APPLICATION;
        try {
            $request = Context::getCurrent()->getRequest();
            $uri     = new Uri($request->getRequestUri());
            $path    = htmlspecialchars($uri->getPath());

            $titleAndDescription = TitleDescriptionTable::getList(array("filter" => array("UF_URL" => $path), "select" => array("ID", "UF_URL", "UF_TITLE", "UF_DESCRIPTION")))->fetch();

            if (! empty($titleAndDescription["UF_TITLE"])) {
                $APPLICATION->SetTitle($titleAndDescription["UF_TITLE"]);
            }
            if (! empty($titleAndDescription["UF_DESCRIPTION"])) {
                $APPLICATION->SetPageProperty("description", $titleAndDescription["UF_DESCRIPTION"]);
            }
        } catch (\Throwable $e) {
            \Bitrix\Main\Diag\Debug::writeToFile($e->getMessage(), "error", "/local/debug.log");
        }
    }
}
