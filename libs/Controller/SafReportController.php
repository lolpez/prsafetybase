<?php
/** @package    SAFEBASE::Controller */

/** import supporting libraries */
require_once("AppBaseController.php");
require_once("Model/SafReport.php");
require_once("Model/SafNotification.php");
require_once("Model/SafMultimedia.php");
require_once("Model/SafReportDetail.php");

/**
 * SafReportController is the controller class for the SafReport object.  The
 * controller is responsible for processing input from the user, reading/updating
 * the model as necessary and displaying the appropriate view.
 *
 * @package SAFEBASE::Controller
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
	}

	/**
	 * Displays a list view of SafReport objects
	 */
    public function Index()
    {
        //Validar
        parent::Validate();
        $this->Assign('reports',$this->Phreezer->Query('SafReportReporter')->ToObjectArray(true, $this->SimpleObjectParams()));
        $this->Assign('departments',$this->Phreezer->Query('SafDepartment')->ToObjectArray(true, $this->SimpleObjectParams()));
        $this->Render("ReportHome");
    }

    public function SingleView(){
        //Validar
        parent::Validate();

        $pk = $this->GetRouter()->GetUrlParam('id');
        $safreport = $this->Phreezer->Get('SafReport',$pk);
        require_once 'Model/SafReportDetailCriteria.php';
        $criteria = new SafReportDetailCriteria();
        $criteria->FkReport_Equals = $safreport->Id;
        $details = $this->Phreezer->Query('SafReportDetail',$criteria)->ToObjectArray(true, $this->SimpleObjectParams());
        $images = array();
        foreach ($details as $r){
            $image = $this->Phreezer->Get('SafMultimedia',$r->fkMultimedia);
            array_push($images,$image->ToObject()->Location);
        }
        $worker =  $this->Phreezer->Get('SafWorker',$safreport->FkWorker);
        $human =  $this->Phreezer->Get('SafHuman',$worker->FkHuman);
        $this->Assign('report', $safreport->ToObject());
        $this->Assign('human', $human->ToObject());
        $this->Assign('images', $images);
        $this->Render("ReportView");
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
				new CriteriaFilter('Id,FkWorker,Date,Time,Description,Latitude,Longitude,ReportType,Enabled'
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

            date_default_timezone_set("America/La_Paz");
            $data = json_decode($_POST['data']);

            $safreport = new SafReport($this->Phreezer);
            $safreport->FkWorker = 1;
            $safreport->Date = date('Y-m-d');
            $safreport->Time = date('H:i:s');
            $safreport->Description = $data->description;
            $safreport->Latitude = $data->latitude;
            $safreport->Longitude = $data->longitude;
            $safreport->ReportType = $data->reportType;

            $safreport->Validate();
            if (count($safreport->GetValidationErrors()) > 0)
            {
                echo json_encode(
                    array(
                        'success'=> false,
                        'message'=> 'Ocurrió un error al registrar un nuevo reporte: '. json_encode($safreport->GetValidationErrors())
                    )
                );
                return;
            }
            $safreport->Save();
            //Multimedia
            if (isset($_FILES)){
                foreach ($_FILES as $file) {
                    //Insert multimedia
                    $safmultimedia = new SafMultimedia($this->Phreezer);
                    $safmultimedia->Extension = pathinfo($file["name"],PATHINFO_EXTENSION);
                    $safmultimedia->Filename = md5(uniqid(rand(), true));
                    $safmultimedia->Location = "resources/images/reports/". $safmultimedia->Filename . "." . $safmultimedia->Extension;
                    $safmultimedia->ThumbLocation = "resources/images/reports/thumb/". $safmultimedia->Filename . "." . $safmultimedia->Extension;
                    $safmultimedia->Type = 1;
                    move_uploaded_file($file['tmp_name'], $safmultimedia->Location);
                    //$this->thumbnail($safmultimedia->Filename . "." . $safmultimedia->Extension, 'resources/images/reports/', 'resources/images/reports/thumb/', 400, 400 );
                    $safmultimedia->Save();
                    //Insert report detail
                    $safreport_detail = new SafReportDetail($this->Phreezer);
                    $safreport_detail->FkMultimedia = $safmultimedia->Id;
                    $safreport_detail->FkReport = $safreport->Id;
                    $safreport_detail->Save();
                }
            }
            //Notification
            if (isset($data->workers)){
                foreach ($data->workers as $workerid) {
                    $safnotification = new SafNotification($this->Phreezer);
                    $safnotification->FkReport = $safreport->Id;
                    $safnotification->FkWorkerOrigin = 1;
                    $safnotification->FkWorkerDestiny = $workerid;
                    $safnotification->Save();
                }
            }
			$report = new stdClass();
			$report->id = $safreport->Id;
			$report->identifier = $data->identifier;
			$report->fkUser = $safreport->FkWorker;
			$report->date = $safreport->Date;
			//$report->time = $safreport->Time;
			$report->description = $safreport->Description;
			$report->latitude = $safreport->Latitude;
			$report->longitude = $safreport->Longitude;
			$report->reportType = $safreport->ReportType;
			$report->sent = true;
			$report->images = array();

            echo json_encode(array('success'=> true, 'message'=> 'Reporte con id: '. $safreport->Id .' registrado correctamente', 't'=>$report));
        }
        catch (Exception $ex)
        {
            echo json_encode(array('success'=> false, 'message'=> 'Ocurrió un error al registrar un nuevo reporte: '. $ex->getMessage()));
        }
	}

    public function thumbnail( $img, $source, $dest, $maxw, $maxh ) {
        $jpg = $source.$img;

        if( $jpg ) {
            list( $width, $height  ) = getimagesize( $jpg );
            $source = imagecreatefromjpeg( $jpg );

            if( $maxw >= $width && $maxh >= $height ) {
                $ratio = 1;
            }elseif( $width > $height ) {
                $ratio = $maxw / $width;
            }else {
                $ratio = $maxh / $height;
            }

            $thumb_width = round( $width * $ratio );
            $thumb_height = round( $height * $ratio );

            $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
            imagecopyresampled($thumb, $source, 0, 0, 0, 0, $thumb_width, $thumb_height, $width, $height );

            $path = $dest.$img;
            imagejpeg( $thumb, $path, 75 );
        }
        imagedestroy($thumb);
        imagedestroy($source);
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

			$safreport->FkWorker = $this->SafeGetVal($json, 'fkWorker', $safreport->FkWorker);
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
