<?php
/** @package    Safebase::Model::DAO */

/** import supporting libraries */
require_once("verysimple/Phreeze/Criteria.php");

/**
 * SafReportCriteria allows custom querying for the SafReport object.
 *
 * WARNING: THIS IS AN AUTO-GENERATED FILE
 *
 * This file should generally not be edited by hand except in special circumstances.
 * Add any custom business logic to the ModelCriteria class which is extended from this class.
 * Leaving this file alone will allow easy re-generation of all DAOs in the event of schema changes
 *
 * @inheritdocs
 * @package Safebase::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SafReportCriteriaDAO extends Criteria
{

	public $Id_Equals;
	public $Id_NotEquals;
	public $Id_IsLike;
	public $Id_IsNotLike;
	public $Id_BeginsWith;
	public $Id_EndsWith;
	public $Id_GreaterThan;
	public $Id_GreaterThanOrEqual;
	public $Id_LessThan;
	public $Id_LessThanOrEqual;
	public $Id_In;
	public $Id_IsNotEmpty;
	public $Id_IsEmpty;
	public $Id_BitwiseOr;
	public $Id_BitwiseAnd;
	public $FkTrabajador_Equals;
	public $FkTrabajador_NotEquals;
	public $FkTrabajador_IsLike;
	public $FkTrabajador_IsNotLike;
	public $FkTrabajador_BeginsWith;
	public $FkTrabajador_EndsWith;
	public $FkTrabajador_GreaterThan;
	public $FkTrabajador_GreaterThanOrEqual;
	public $FkTrabajador_LessThan;
	public $FkTrabajador_LessThanOrEqual;
	public $FkTrabajador_In;
	public $FkTrabajador_IsNotEmpty;
	public $FkTrabajador_IsEmpty;
	public $FkTrabajador_BitwiseOr;
	public $FkTrabajador_BitwiseAnd;
	public $Date_Equals;
	public $Date_NotEquals;
	public $Date_IsLike;
	public $Date_IsNotLike;
	public $Date_BeginsWith;
	public $Date_EndsWith;
	public $Date_GreaterThan;
	public $Date_GreaterThanOrEqual;
	public $Date_LessThan;
	public $Date_LessThanOrEqual;
	public $Date_In;
	public $Date_IsNotEmpty;
	public $Date_IsEmpty;
	public $Date_BitwiseOr;
	public $Date_BitwiseAnd;
	public $Time_Equals;
	public $Time_NotEquals;
	public $Time_IsLike;
	public $Time_IsNotLike;
	public $Time_BeginsWith;
	public $Time_EndsWith;
	public $Time_GreaterThan;
	public $Time_GreaterThanOrEqual;
	public $Time_LessThan;
	public $Time_LessThanOrEqual;
	public $Time_In;
	public $Time_IsNotEmpty;
	public $Time_IsEmpty;
	public $Time_BitwiseOr;
	public $Time_BitwiseAnd;
	public $Description_Equals;
	public $Description_NotEquals;
	public $Description_IsLike;
	public $Description_IsNotLike;
	public $Description_BeginsWith;
	public $Description_EndsWith;
	public $Description_GreaterThan;
	public $Description_GreaterThanOrEqual;
	public $Description_LessThan;
	public $Description_LessThanOrEqual;
	public $Description_In;
	public $Description_IsNotEmpty;
	public $Description_IsEmpty;
	public $Description_BitwiseOr;
	public $Description_BitwiseAnd;
	public $Latitude_Equals;
	public $Latitude_NotEquals;
	public $Latitude_IsLike;
	public $Latitude_IsNotLike;
	public $Latitude_BeginsWith;
	public $Latitude_EndsWith;
	public $Latitude_GreaterThan;
	public $Latitude_GreaterThanOrEqual;
	public $Latitude_LessThan;
	public $Latitude_LessThanOrEqual;
	public $Latitude_In;
	public $Latitude_IsNotEmpty;
	public $Latitude_IsEmpty;
	public $Latitude_BitwiseOr;
	public $Latitude_BitwiseAnd;
	public $Longitude_Equals;
	public $Longitude_NotEquals;
	public $Longitude_IsLike;
	public $Longitude_IsNotLike;
	public $Longitude_BeginsWith;
	public $Longitude_EndsWith;
	public $Longitude_GreaterThan;
	public $Longitude_GreaterThanOrEqual;
	public $Longitude_LessThan;
	public $Longitude_LessThanOrEqual;
	public $Longitude_In;
	public $Longitude_IsNotEmpty;
	public $Longitude_IsEmpty;
	public $Longitude_BitwiseOr;
	public $Longitude_BitwiseAnd;
	public $ReportType_Equals;
	public $ReportType_NotEquals;
	public $ReportType_IsLike;
	public $ReportType_IsNotLike;
	public $ReportType_BeginsWith;
	public $ReportType_EndsWith;
	public $ReportType_GreaterThan;
	public $ReportType_GreaterThanOrEqual;
	public $ReportType_LessThan;
	public $ReportType_LessThanOrEqual;
	public $ReportType_In;
	public $ReportType_IsNotEmpty;
	public $ReportType_IsEmpty;
	public $ReportType_BitwiseOr;
	public $ReportType_BitwiseAnd;
	public $Enabled_Equals;
	public $Enabled_NotEquals;
	public $Enabled_IsLike;
	public $Enabled_IsNotLike;
	public $Enabled_BeginsWith;
	public $Enabled_EndsWith;
	public $Enabled_GreaterThan;
	public $Enabled_GreaterThanOrEqual;
	public $Enabled_LessThan;
	public $Enabled_LessThanOrEqual;
	public $Enabled_In;
	public $Enabled_IsNotEmpty;
	public $Enabled_IsEmpty;
	public $Enabled_BitwiseOr;
	public $Enabled_BitwiseAnd;

}

?>