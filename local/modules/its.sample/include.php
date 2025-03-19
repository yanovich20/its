<?php
use Bitrix\Main\Loader;

Loader::registerAutoloadClasses("its.sample",array("\\ITS\\PrologEventHandler"=>"lib/PrologEventHandler.php"));
Loader::registerAutoloadClasses("its.sample",array("\\ITS\\TitleDescriptionTable"=>"lib/TitleDescriptionTable.php"));
Loader::registerAutoloadClasses("its.sample",array("\\ITS\\EpilogEventHandler"=>"lib/EpilogEventHandler.php"));

