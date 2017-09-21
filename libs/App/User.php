<?php
/** @package    User::App */

/** import supporting libraries */
require_once("verysimple/Authentication/IAuthenticatable.php");
require_once("util/password.php");

/**
 * The ExampleUser is a simple account object that demonstrates a simplistic way
 * to handle authentication.  Note that this uses a hard-coded username/password
 * combination (see inside the __construct method).
 * 
 * A better approach is to use one of your existing model classes and implement
 * IAuthenticatable inside that class.
 *
 * @package Example::App
 * @author ClassBuilder
 * @version 1.0
 */
class User implements IAuthenticatable
{
	/**
	 * @var Array hard-coded. initialized on contruction
	 */

	
	public $Id = '';
	public $User = '';
	public $Name = '';
	public $Ci = '';
	public $Enrollment = '';
	public $BloodType = '';
	public $PhoneNumber = '';
	public $RoleId = '';
	public $RoleName = '';
	public $DepartmentId = '';
	public $DepartmentName = '';

	/**
	 * Initialize contruction
	 */
	public function __construct()
	{

	}

	/**
	 * Returns true if the user is anonymous (not logged in)
	 * @see IAuthenticatable
	 */
	public function IsAnonymous()
	{
		return $this->Username == '';
	}

	/**
	 * This is a hard-coded way of checking permission.  A better approach would be to look up
	 * this information in the database or base it on the account type
	 *
	 * @see IAuthenticatable
	 * @param int $permission
	 */
	public function IsAuthorized($permission)
	{

	}

	/**
	 * This login method uses hard-coded username/passwords.  This is ok for simple apps
	 * but for a more robust application this would do a database lookup instead.
	 * The Username is used as a mechanism to determine whether the user is logged in or
	 * not
	 *
	 * @see IAuthenticatable
	 * @param string $username
	 * @param string $password
	 */
	public function Login($query,$password)
	{
        $this->Id = $query->id;
        $this->User = $query->user;
        $this->Name = $query->name;
        $this->Ci = $query->ci;
        $this->Enrollment = $query->enrollment;
        $this->BloodType = $query->bloodType;
        $this->PhoneNumber = $query->phoneNumber;
        $this->RoleId = $query->roleId;
        $this->RoleName = $query->roleName;
        $this->DepartmentId = $query->departmentId;
        $this->DepartmentName = $query->departmentName;
	}
	
}

?>