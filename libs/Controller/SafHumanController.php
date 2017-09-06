<?php
/** @package    PrSafetyBase WEB::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/SafHuman.php");

/**
 * SafHumanController is the controller class for the SafHuman object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package PrSafetyBase WEB::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class SafHumanController extends AppBaseController
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
	 * Displays a list view of SafHuman objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for SafHuman records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new SafHumanCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,Ci,Name,BloodType,PhoneNumber,Enabled'
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

				$safhumans = $this->Phreezer->Query('SafHuman',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $safhumans->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $safhumans->TotalResults;
				$output->totalPages = $safhumans->TotalPages;
				$output->pageSize = $safhumans->PageSize;
				$output->currentPage = $safhumans->CurrentPage;
			}
			else
			{
				// return all results
				$safhumans = $this->Phreezer->Query('SafHuman',$criteria);
				$output->rows = $safhumans->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single SafHuman record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$safhuman = $this->Phreezer->Get('SafHuman',$pk);
			$this->RenderJSON($safhuman, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new SafHuman record and render response as JSON
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

			$safhuman = new SafHuman($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $safhuman->Id = $this->SafeGetVal($json, 'id');

			$safhuman->Ci = $this->SafeGetVal($json, 'ci');
			$safhuman->Name = $this->SafeGetVal($json, 'name');
			$safhuman->BloodType = $this->SafeGetVal($json, 'bloodType');
			$safhuman->PhoneNumber = $this->SafeGetVal($json, 'phoneNumber');
			$safhuman->Enabled = $this->SafeGetVal($json, 'enabled');

			$safhuman->Validate();
			$errors = $safhuman->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$safhuman->Save();
				$this->RenderJSON($safhuman, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing SafHuman record and render response as JSON
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
			$safhuman = $this->Phreezer->Get('SafHuman',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $safhuman->Id = $this->SafeGetVal($json, 'id', $safhuman->Id);

			$safhuman->Ci = $this->SafeGetVal($json, 'ci', $safhuman->Ci);
			$safhuman->Name = $this->SafeGetVal($json, 'name', $safhuman->Name);
			$safhuman->BloodType = $this->SafeGetVal($json, 'bloodType', $safhuman->BloodType);
			$safhuman->PhoneNumber = $this->SafeGetVal($json, 'phoneNumber', $safhuman->PhoneNumber);
			$safhuman->Enabled = $this->SafeGetVal($json, 'enabled', $safhuman->Enabled);

			$safhuman->Validate();
			$errors = $safhuman->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$safhuman->Save();
				$this->RenderJSON($safhuman, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing SafHuman record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$safhuman = $this->Phreezer->Get('SafHuman',$pk);

			$safhuman->Delete();

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
