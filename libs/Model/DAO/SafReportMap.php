<?php
/** @package    Safebase::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * SafReportMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the SafReportDAO to the saf_report datastore.
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
class SafReportMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","saf_report","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["FkTrabajador"] = new FieldMap("FkTrabajador","saf_report","fk_trabajador",false,FM_TYPE_INT,11,null,false);
			self::$FM["Date"] = new FieldMap("Date","saf_report","date",false,FM_TYPE_DATE,null,null,false);
			self::$FM["Time"] = new FieldMap("Time","saf_report","time",false,FM_TYPE_TIME,null,null,false);
			self::$FM["Description"] = new FieldMap("Description","saf_report","description",false,FM_TYPE_TEXT,null,null,false);
			self::$FM["Latitude"] = new FieldMap("Latitude","saf_report","latitude",false,FM_TYPE_FLOAT,null,null,false);
			self::$FM["Longitude"] = new FieldMap("Longitude","saf_report","longitude",false,FM_TYPE_FLOAT,null,null,false);
			self::$FM["ReportType"] = new FieldMap("ReportType","saf_report","report_type",false,FM_TYPE_INT,11,null,false);
			self::$FM["Enabled"] = new FieldMap("Enabled","saf_report","enabled",false,FM_TYPE_TINYINT,1,"1",false);
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