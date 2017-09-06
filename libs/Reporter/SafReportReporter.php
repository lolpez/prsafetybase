<?php
/** @package    Safebase::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the SafReport object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Safebase::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SafReportReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `saf_report` table
	public $CustomFieldExample;

	public $Id;
	public $FkTrabajador;
	public $Date;
	public $Time;
	public $Description;
	public $Latitude;
	public $Longitude;
	public $ReportType;
	public $Enabled;

	/*
	* GetCustomQuery returns a fully formed SQL statement.  The result columns
	* must match with the properties of this reporter object.
	*
	* @see Reporter::GetCustomQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`saf_report`.`id` as Id
			,`saf_report`.`fk_trabajador` as FkTrabajador
			,`saf_report`.`date` as Date
			,`saf_report`.`time` as Time
			,`saf_report`.`description` as Description
			,`saf_report`.`latitude` as Latitude
			,`saf_report`.`longitude` as Longitude
			,`saf_report`.`report_type` as ReportType
			,`saf_report`.`enabled` as Enabled
		from `saf_report`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	/*
	* GetCustomCountQuery returns a fully formed SQL statement that will count
	* the results.  This query must return the correct number of results that
	* GetCustomQuery would, given the same criteria
	*
	* @see Reporter::GetCustomCountQuery
	* @param Criteria $criteria
	* @return string SQL statement
	*/
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `saf_report`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>