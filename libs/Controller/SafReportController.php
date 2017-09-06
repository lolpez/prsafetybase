<?php
/** @package    PrSafetyBase WEB::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/SafReport.php");

/**
 * SafReportController is the controller class for the SafReport object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package PrSafetyBase WEB::Controller
 * @author ClassBuilder
 * @version 1.0
 */
class SafReportController extends AppBaseController
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
	 * Displays a list view of SafReport objects
	 */
	public function ListView()
	{
		$this->Render();
	}

	/**
	 * API Method queries for SafReport records and render as JSON
	 */
	public function Query()
	{
		try
		{
			$criteria = new SafReportCriteria();
			
			// TODO: this will limit results based on all properties included in the filter list 
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Id,FkTrabajador,Date,Time,Description,Latitude,Longitude,ReportType,Enabled'
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

				$safreports = $this->Phreezer->Query('SafReport',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $safreports->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $safreports->TotalResults;
				$output->totalPages = $safreports->TotalPages;
				$output->pageSize = $safreports->PageSize;
				$output->currentPage = $safreports->CurrentPage;
			}
			else
			{
				// return all results
				$safreports = $this->Phreezer->Query('SafReport',$criteria);
				$output->rows = $safreports->ToObjectArray(true, $this->SimpleObjectParams());
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
	 * API Method retrieves a single SafReport record and render as JSON
	 */
	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('id');
			$safreport = $this->Phreezer->Get('SafReport',$pk);
			$this->RenderJSON($safreport, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method inserts a new SafReport record and render response as JSON
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

			$safreport = new SafReport($this->Phreezer);

			// TODO: any fields that should not be inserted by the user should be commented out

			// this is an auto-increment.  uncomment if updating is allowed
			// $safreport->Id = $this->SafeGetVal($json, 'id');

			$safreport->FkTrabajador = $this->SafeGetVal($json, 'fkTrabajador');
			$safreport->Date = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'date')));
			$safreport->Time = date('H:i:s',strtotime('1970-01-01 ' . $this->SafeGetVal($json, 'time')));
			$safreport->Description = $this->SafeGetVal($json, 'description');
			$safreport->Latitude = $this->SafeGetVal($json, 'latitude');
			$safreport->Longitude = $this->SafeGetVal($json, 'longitude');
			$safreport->ReportType = $this->SafeGetVal($json, 'reportType');
			$safreport->Enabled = $this->SafeGetVal($json, 'enabled');

			$safreport->Validate();
			$errors = $safreport->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$safreport->Save();
				$this->RenderJSON($safreport, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method updates an existing SafReport record and render response as JSON
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
			$safreport = $this->Phreezer->Get('SafReport',$pk);

			// TODO: any fields that should not be updated by the user should be commented out

			// this is a primary key.  uncomment if updating is allowed
			// $safreport->Id = $this->SafeGetVal($json, 'id', $safreport->Id);

			$safreport->FkTrabajador = $this->SafeGetVal($json, 'fkTrabajador', $safreport->FkTrabajador);
			$safreport->Date = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'date', $safreport->Date)));
			$safreport->Time = date('Y-m-d H:i:s',strtotime('1970-01-01 ' . $this->SafeGetVal($json, 'time', $safreport->Time)));
			$safreport->Description = $this->SafeGetVal($json, 'description', $safreport->Description);
			$safreport->Latitude = $this->SafeGetVal($json, 'latitude', $safreport->Latitude);
			$safreport->Longitude = $this->SafeGetVal($json, 'longitude', $safreport->Longitude);
			$safreport->ReportType = $this->SafeGetVal($json, 'reportType', $safreport->ReportType);
			$safreport->Enabled = $this->SafeGetVal($json, 'enabled', $safreport->Enabled);

			$safreport->Validate();
			$errors = $safreport->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$safreport->Save();
				$this->RenderJSON($safreport, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	/**
	 * API Method deletes an existing SafReport record and render response as JSON
	 */
	public function Delete()
	{
		try
		{
						
			// TODO: if a soft delete is prefered, change this to update the deleted flag instead of hard-deleting

			$pk = $this->GetRouter()->GetUrlParam('id');
			$safreport = $this->Phreezer->Get('SafReport',$pk);

			$safreport->Delete();

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
