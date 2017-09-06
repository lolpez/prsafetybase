<?php
/** @package    Safebase::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * SafMultimediaMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the SafMultimediaDAO to the saf_multimedia datastore.
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
class SafMultimediaMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","saf_multimedia","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["Filename"] = new FieldMap("Filename","saf_multimedia","filename",false,FM_TYPE_VARCHAR,50,null,false);
			self::$FM["Extension"] = new FieldMap("Extension","saf_multimedia","extension",false,FM_TYPE_VARCHAR,5,null,false);
			self::$FM["Location"] = new FieldMap("Location","saf_multimedia","location",false,FM_TYPE_VARCHAR,200,null,false);
			self::$FM["Type"] = new FieldMap("Type","saf_multimedia","type",false,FM_TYPE_INT,11,null,false);
			self::$FM["Enabled"] = new FieldMap("Enabled","saf_multimedia","enabled",false,FM_TYPE_TINYINT,1,"1",false);
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