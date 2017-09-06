<?php
/** @package    Safebase::Model */

/** import supporting libraries */
require_once("DAO/SafWorkerDAO.php");
require_once("SafWorkerCriteria.php");

/**
 * The SafWorker class extends SafWorkerDAO which provides the access
 * to the datastore.
 *
 * @package Safebase::Model
 * @author ClassBuilder
 * @version 1.0
 */
class SafWorker extends SafWorkerDAO
{

	/**
	 * Override default validation
	 * @see Phreezable::Validate()
	 */
	public function Validate()
	{
		// example of custom validation
		// $this->ResetValidationErrors();
		// $errors = $this->GetValidationErrors();
		// if ($error == true) $this->AddValidationError('FieldName', 'Error Information');
		// return !$this->HasValidationErrors();

		return parent::Validate();
	}

	/**
	 * @see Phreezable::OnSave()
	 */
	public function OnSave($insert)
	{
		// the controller create/update methods validate before saving.  this will be a
		// redundant validation check, however it will ensure data integrity at the model
		// level based on validation rules.  comment this line out if this is not desired
		if (!$this->Validate()) throw new Exception('Unable to Save SafWorker: ' .  implode(', ', $this->GetValidationErrors()));

		// OnSave must return true or Phreeze will cancel the save operation
		return true;
	}

}

?>
