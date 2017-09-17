<?php
/** @package    Safebase::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * SafReportDetailMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the SafReportDetailDAO to the saf_report_detail datastore.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * You can override the default fetching strategies for KeyMaps in _config.php.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @package Safebase::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SafReportDetailMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	/**
	 * {@inheritdoc}
	 */
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	/**
	 * {@inheritdoc}
	 */
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Id"] = new FieldMap("Id","saf_report_detail","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["FkReport"] = new FieldMap("FkReport","saf_report_detail","fk_report",false,FM_TYPE_INT,11,null,false);
			self::$FM["FkMultimedia"] = new FieldMap("FkMultimedia","saf_report_detail","fk_multimedia",false,FM_TYPE_INT,11,null,false);
			self::$FM["Enabled"] = new FieldMap("Enabled","saf_report_detail","enabled",false,FM_TYPE_TINYINT,1,"1",false);
		}
		return self::$FM;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
		}
		return self::$KM;
	}

}

?>