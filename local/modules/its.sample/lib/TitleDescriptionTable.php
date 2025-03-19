<?php 
namespace ITS;

use Bitrix\Main\Entity\DataManager;

class TitleDescriptionTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'title_description';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
				'title' => "ID",
			),
			'UF_URL' => array(
				'data_type' => 'text',
				'title' => 'URL'
			),
			'UF_TITLE' => array(
				'data_type' => 'text',
				'title' => 'Название',
			),
            'UF_DESCRIPTION'=>array(
                'data_type' => 'text',
				'title' => 'Описание',
            ),
		);
	}
}