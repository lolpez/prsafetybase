<?php
/** @package    Safebase::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * SafHumanMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the SafHumanDAO to the saf_human datastore.
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
class SafHumanMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","saf_human","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["Ci"] = new FieldMap("Ci","saf_human","ci",false,FM_TYPE_INT,11,null,false);
			self::$FM["Name"] = new FieldMap("Name","saf_human","name",false,FM_TYPE_VARCHAR,50,null,false);
			self::$FM["BloodType"] = new FieldMap("BloodType","saf_human","blood_type",false,FM_TYPE_VARCHAR,10,null,false);
			self::$FM["PhoneNumber"] = new FieldMap("PhoneNumber","saf_human","phone_number",false,FM_TYPE_INT,11,null,false);
			self::$FM["Enabled"] = new FieldMap("Enabled","saf_human","enabled",false,FM_TYPE_TINYINT,1,"1",false);
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