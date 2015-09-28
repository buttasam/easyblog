<?php

namespace App\FrontModule\Presenters;

use Nette;


/**
 * Base presenter for all application presenters.
 */
abstract class BasePresenter extends Nette\Application\UI\Presenter
{

	/**
	 * @param  mixed $record
	 * @param  string $message
	 * @return bool if ok
	 * @throws Nette\Application\BadRequestException
	 */
	public function checkRecord($record, $message = 'Record not found')
	{
		if ($record == NULL) {
			$this->error($message);
		}

		return TRUE;
	}

	protected function authorize()
	{
		if (!$this->user->isInRole('admin')) {
			$this->redirect('default');
		}
	}
}
