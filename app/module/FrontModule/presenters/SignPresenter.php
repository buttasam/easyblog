<?php

namespace App\FrontModule\Presenters;

use Nette\Application\UI\Form;
use App\Model\Repository\UserRepository;
use \Nette\Security\AuthenticationException;


/**
 * Sign in/out presenters.
 */
class SignPresenter extends BasePresenter
{

	/** @var UserRepository */
	private $users;


	public function __construct(UserRepository $users)
	{
		$this->users = $users;
	}


	protected function createComponentSignInForm()
	{
		$form = new Form();
		$form->addText('username', 'Jméno:');
		$form->addPassword('password', 'Name');
		$form->addSubmit('btnLogin', 'Přihlásit');
		$form->addCheckbox('remember');

		$form->onSuccess[] = $this->signInFormSucceeded;
		return $form;
	}


	public function signInFormSucceeded(Form $form, $values)
	{
		try {
			$this->user->login($values->username, $values->password);

			if ($values->remember) {
				$this->user->setExpiration('7 day', FALSE);

			} else {
				$this->user->setExpiration('30 minutes', TRUE);
			}

			$this->flashMessage('Úspěšné přihlášení', 'success');
			$this->redirect('Article:default');

		} catch (AuthenticationException $e) {
			$this->flashMessage('Špatné jméno nebo heslo.', 'error');
		}
	}


	protected function createComponentRegisterForm()
	{
		$form = new Form;

		$form->addText('email', 'E-mail:')
				->setRequired();

		$form->addPassword('password', 'Helso:')
				->setRequired();

		$form->addPassword('password2', 'Heslo znovu:')
				->setOmitted(TRUE)
				->setRule(Form::EQUAL, NULL, $form['password'])
				->setRequired();

		$form->addText('name', 'Celé jméno:')
				->setRequired();

		$form->addCheckbox('remember', 'Trvalé přihlášení');
		$form->addSubmit('btnRegister', 'Registrovat');

		$form->onSuccess[] = $this->registerFormSucceeded;
		return $form;
	}


	public function registerFormSucceeded(Form $form, $values)
	{
		try {
			$user = $this->users->createEntity();
			$user->setUsername($values->name);
			$user->setPassword($values->password);
			$this->users->persist($user);
			$this->redirect('Sign:in');

		} catch (\App\Model\Repository\DuplicateNameException $e) {
			$form['username']->addError('Toto uživatelské jméno je již použité. Zvolte prosím jiné.');

		} catch (\Exception $e) {
			\Tracy\Debugger::log($e);
			$form->addError('Při registraci došlo k neočekávané chybě. Zkuste to prosím znovu.');
		}
	}


	public function actionOut()
	{
		$this->getUser()->logout(TRUE);
		$this->flashMessage('Úspěšné odhlášení.', 'success');
		$this->redirect('in');
	}

}
