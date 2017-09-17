<?php
/** @package    Safebase::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

/**
 * SafWorkerMap is a static class with functions used to get FieldMap and KeyMap information that
 * is used by Phreeze to map the SafWorkerDAO to the saf_worker datastore.
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
class SafWorkerMap implements IDaoMap, IDaoMap2
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
			self::$FM["Id"] = new FieldMap("Id","saf_worker","id",true,FM_TYPE_INT,11,null,true);
			self::$FM["User"] = new FieldMap("User","saf_worker","user",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Password"] = new FieldMap("Password","saf_worker","password",false,FM_TYPE_VARCHAR,20,null,false);
			self::$FM["Enrollment"] = new FieldMap("Enrollment","saf_worker","enrollment",false,FM_TYPE_INT,11,null,false);
			self::$FM["FkHuman"] = new FieldMap("FkHuman","saf_worker","fk_human",false,FM_TYPE_INT,11,null,false);
			self::$FM["FkRole"] = new FieldMap("FkRole","saf_worker","fk_role",false,FM_TYPE_INT,11,null,false);
			self::$FM["FkDepartment"] = new FieldMap("FkDepartment","saf_worker","fk_department",false,FM_TYPE_INT,11,null,false);
			self::$FM["Enabled"] = new FieldMap("Enabled","saf_worker","enabled",false,FM_TYPE_TINYINT,1,"1",false);
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