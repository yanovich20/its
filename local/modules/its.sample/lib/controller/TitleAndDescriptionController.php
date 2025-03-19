<?php
namespace Its\Sample\Controller;

use Bitrix\Main\Context;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\ActionFilter\Csrf;
use Bitrix\Main\Engine\ActionFilter\HttpMethod;
use Bitrix\Main\Web\Uri;
use ITS\TitleDescriptionTable;

class TitleAndDescriptionController extends Controller
{
	/**
	 * @return array
	 */
	public function configureActions()
	{
		return [
			'save' => [
				'prefilters' => [
                    new HttpMethod(
                        array(HttpMethod::METHOD_POST)
                    ),
                    new Csrf(),
                ],
			]
		];
	}
 
	/**
	 * @return array
	 */
	public static function saveAction()
	{
        $request = Context::getCurrent()->getRequest();
        $ufUrl = $request->get("UF_URL");
        $ufTitle = $request->get("UF_TITLE");
        $ufDescription = $request->get("UF_DESCRIPTION");

        if(empty($ufUrl)){
            return array("status"=>"errror","message"=>"Не заполнен адрес");
        }
        if(empty($ufTitle)){
            return array("status"=>"errror","message"=>"Не заполнен заголовок");
        }
        if(empty($ufDescription)){
            return array("status"=>"errror","message"=>"Не заполнено описание");
        }

        $addParams = array(
            "UF_URL"=>htmlspecialchars($ufUrl),
            "UF_TITLE"=>htmlspecialchars($ufTitle),
            "UF_DESCRIPTION"=>htmlspecialchars($ufDescription)
        );
        $titleAndDescription = TitleDescriptionTable::getList(array("filter"=>array("UF_URL"=>htmlspecialchars($ufUrl)),"select"=>array("ID","UF_URL","UF_TITLE","UF_DESCRIPTION")))->fetch();
        if(empty($titleAndDescription)){
            $result = TitleDescriptionTable::add($addParams);
        }
        else{
            $result = TitleDescriptionTable::update($titleAndDescription["ID"],$addParams);
        }
        if(!$result->isSuccess())
        {
            $errors = $result->getErrors();
            $message ="";
            foreach ($errors as $error) {
              $message .= " " . $error->getMessage();
            }
            return array("status"=>"error","message"=>$message);
        }
        else return array(
			'status' => "success",
			'message' => "Данные сохранены успешно"
        );

	}
}