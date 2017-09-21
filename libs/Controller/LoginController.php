<?php
/** @package Login::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("App/User.php");
/**
 * SecureExampleController is a sample controller to demonstrate
 * one approach to authentication in a Phreeze app
 *
 * @package Cargo::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class LoginController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 */
	protected function Init()
	{
		parent::Init();
	}
	
	/**
	 * Display the login form
	 */
	public function LoginForm()
	{
        if ($this->GetCurrentUser()){
            $this->Redirect('Default.Home');
            return;
        }
		$this->Assign("currentUser", $this->GetCurrentUser());
		$this->Assign('page','login');
		$this->Render("Login");
	}
	
	/**
	 * Process the login, create the user session and then redirect to 
	 * the appropriate page
	 */
	public function Login()
	{
		$json = json_decode(RequestUtil::GetBody());

        $username = $this->SafeGetVal($json, 'username');
        $password = $this->SafeGetVal($json, 'password');
        $api = $this->SafeGetVal($json, 'api');

        require_once 'Model/SafWorkerCriteria.php';
        $criteria = new SafWorkerCriteria();
        $criteria->Enabled_Equals = 1;
        $criteria->Password_Equals = $password;
        $criteria->User_Equals = $username;
        $query = $this->Phreezer->Query('SafLoginReporter',$criteria)->ToObjectArray(true, $this->SimpleObjectParams());
        if (count($query)==1){
            // login success
            $user = new User();
            $user->Login($query[0], null);
            $this->SetCurrentUser($user);
            if ($api){
                $object = new stdClass();
                $object->id=$this->GetCurrentUser()->Id;
                $object->name=$this->GetCurrentUser()->Name;
                $object->ci=$this->GetCurrentUser()->Ci;
                $object->enrollment=$this->GetCurrentUser()->Enrollment;
                $object->bloodType=$this->GetCurrentUser()->BloodType;
                $object->department=$this->GetCurrentUser()->DepartmentId;
                $object->role=$this->GetCurrentUser()->RoleId;
                $object->phoneNumber=$this->GetCurrentUser()->PhoneNumber;
                echo json_encode(array('success'=> true, 'message'=> 'Login correcto', 't'=>$object));
                return;
            }
        }else{
            // login failed
            if ($api){
                echo json_encode(array('success'=> false, 'message'=> 'Datos incorrectos.', 't'=>null));
                return;
            }
			$this->Redirect('Login.LoginForm','Datos incorrectos.');
        }
	}
	
	/**
	 * Clear the user session and redirect to the login page
	 */
	public function Logout()
	{
		$this->ClearCurrentUser();
		$this->Redirect("Login.LoginForm");
	}

}
?>