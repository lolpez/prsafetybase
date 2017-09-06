<?php
/** @package    PrSafetyBase WEB::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/SafDepartmentDetail.php");

/**
 * SafDepartmentDetailController is the controller class for the SafDepartmentDetail object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package PrSafetyBase WEB::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class SafDepartmentDetailController extends AppBaseController
{

	/**
	 * Override here for any controller-specific functionality
	 *
	 * @inheritdocs
	 */
	protected function Init()
	{
		parent::Init();

		// TODO: add controller-wide bootstrap code
		
		// TODO: if authentiation is required for this entire controller, for example:
		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	/**
	 * Displays a list view of SafDepartmentDetail objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for SafDepartmentDetail records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new SafDepartmentDetailCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,FkDepartment,FkMultimedia,Enabled'
				, '%'.$filter.'%')
			);

			// TODO: this is generic query filtering based only on criteria properties
			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					// this is a convenience so that the _Equals suffix is not needed
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

			// if a sort order was specified then specify in the criteria
 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				// if page is specified, use this instead (at the expense of one extra count query)
				$pagesize = $this->GetDefaultPageSize();

				$safdepartmentdetails = $this->Phreezer->Query('SafDepartmentDetail',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $safdepartmentdetails->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $safdepartmentdetails->TotalResults;
				$output->totalPages = $safdepartmentdetails->TotalPages;
				$output->pageSize = $safdepartmentdetails->PageSize;
				$output->currentPage = $safdepartmentdetails->CurrentPage;
			}
			else
			{
				// return all results
				$safdepartmentdetails = $this->Phreezer->Query('SafDepartmentDetail',$criteria);
				$output->rows = $safdepartmentdetails->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method retrieves a single SafDepartmentDetail record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$safdepartmentdetail = $this->Phreezer->Get('SafDepartmentDetail',$pk);
			$this->RenderJSON($safdepartmentdetail, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new SafDepartmentDetail record and render response as JSON
	 */
	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$safdepartmentdetail = new SafDepartmentDetail($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $safdepartmentdetail->Id = $this->SafeGetVal($json, 'id');

			$safdepartmentdetail->FkDepartment = $this->SafeGetVal($json, 'fkDepartment');
			$safdepartmentdetail->FkMultimedia = $this->SafeGetVal($json, 'fkMultimedia');
			$safdepartmentdetail->Enabled = $this->SafeGetVal($json, 'enabled');

			$safdepartmentdetail->Validate();
			$errors = $safdepartmentdetail->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$safdepartmentdetail->Save();
				$this->RenderJSON($safdepartmentdetail, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing SafDepartmentDetail record and render response as JSON
	 */
	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('id');
			$safdepartmentdetail = $this->Phreezer->Get('SafDepartmentDetail',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $safdepartmentdetail->Id = $this->SafeGetVal($json, 'id', $safdepartmentdetail->Id);

			$safdepartmentdetail->FkDepartment = $this->SafeGetVal($json, 'fkDepartment', $safdepartmentdetail->FkDepartment);
			$safdepartmentdetail->FkMultimedia = $this->SafeGetVal($json, 'fkMultimedia', $safdepartmentdetail->FkMultimedia);
			$safdepartmentdetail->Enabled = $this->SafeGetVal($json, 'enabled', $safdepartmentdetail->Enabled);

			$safdepartmentdetail->Validate();
			$errors = $safdepartmentdetail->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$safdepartmentdetail->Save();
				$this->RenderJSON($safdepartmentdetail, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing SafDepartmentDetail record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$safdepartmentdetail = $this->Phreezer->Get('SafDepartmentDetail',$pk);

			$safdepartmentdetail->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
