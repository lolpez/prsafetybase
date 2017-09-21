<?php
/** @package    Safebase::Reporter */

/** import supporting libraries */
require_once("verysimple/Phreeze/Reporter.php");

/**
 * This is an example Reporter based on the SafWorker object.  The reporter object
 * allows you to run arbitrary queries that return data which may or may not fith within
 * the data access API.  This can include aggregate data or subsets of data.
 *
 * Note that Reporters are read-only and cannot be used for saving data.
 *
 * @package Safebase::Model::DAO
 * @author ClassBuilder
 * @version 1.0
 */
class SafLoginReporter extends Reporter
{

	// the properties in this class must match the columns returned by GetCustomQuery().
	// 'CustomFieldExample' is an example that is not part of the `saf_worker` table
	public $Name;
	public $Ci;
	public $BloodType;
	public $PhoneNumber;
	public $RoleId;
	public $RoleName;
	public $DepartmentId;
	public $DepartmentName;

	public $Id;
	public $User;
	public $Password;
	public $Enrollment;
	public $FkHuman;
	public $FkRole;
	public $FkDepartment;
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
			`saf_human`.`name` as Name
			,`saf_human`.`ci` as Ci
			,`saf_human`.`blood_type` as BloodType
			,`saf_human`.`phone_number` as PhoneNumber
			,`saf_role`.`id` as RoleId
			,`saf_role`.`name` as RoleName
			,`saf_department`.`id` as DepartmentId
			,`saf_department`.`name` as DepartmentName
			,`saf_worker`.`id` as Id
			,`saf_worker`.`user` as User
			,`saf_worker`.`password` as Password
			,`saf_worker`.`enrollment` as Enrollment
			,`saf_worker`.`fk_human` as FkHuman
			,`saf_worker`.`fk_role` as FkRole
			,`saf_worker`.`fk_department` as FkDepartment
			,`saf_worker`.`enabled` as Enabled
		from `saf_worker`
		inner join saf_human on `saf_worker`.`fk_human`= `saf_human`.`id`
		inner join saf_department on `saf_worker`.`fk_department`= `saf_department`.`id`
		inner join saf_role on `saf_worker`.`fk_role` = `saf_role`.`id`";

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
		$sql = "select count(1) as counter
                from `saf_worker`
                inner join saf_human on `saf_worker`.`fk_human`= `saf_human`.`id`
                inner join saf_department on `saf_worker`.`fk_department`= `saf_department`.`id`
                inner join saf_role on `saf_worker`.`fk_role` = `saf_role`.`id`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>