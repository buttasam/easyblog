<?php
/**
 * Created by PhpStorm.
 * User: samik
 * Date: 28.9.15
 * Time: 19:17
 */

namespace App\FrontModule\Presenters;

use App\Model\Entity\Category;
use App\Model\Repository\CategoryRepository;
use Nette\Application\UI\Form;

class CategoryPresenter extends BasePresenter
{

	/** @var  CategoryRepository */
	private $categories;

	/** @var null | Category */
	private $category = NULL;

	/**
	 * CategoryPresenter constructor.
	 * @param CategoryRepository $categories
	 */
	public function __construct(CategoryRepository $categories)
	{
		$this->categories = $categories;
	}

	public function actionDefault($categoryId)
	{
		if ($categoryId !== NULL) {
			$this->category = $this->categories->getByID($categoryId);

			$this['categoryForm']->setDefaults(array(
				'title' => $this->category->getTitle()
			));
		}
	}

	public function renderDefault()
	{
		$this->template->categories = $this->categories->findAll();
	}

	public function actionDetail($categoryId)
	{
		$this->category = $this->categories->getByID($categoryId);
	}

	public function renderDetail()
	{
		$this->template->articles = $this->category->getAllArticles();

	}

	protected function createComponentCategoryForm()
	{
		$form = new Form();

		$form->addText('title', 'Název:');

		$form->addSubmit('send', 'Send');
		$form->onSuccess[] = $this->processCategoryForm;

		return $form;
	}

	public function processCategoryForm(Form $form, $values)
	{

		if ($this->category == NULL) {
			$this->category = $this->categories->createEntity();
		}

		$this->category->setTitle($values->title);
		$this->categories->persist($this->category);

		$this->redirect('Category:');
	}

	public function handleDeleteCategory($categoryId)
	{
		$this->category = $this->categories->getByID($categoryId);

		$this->categories->delete($this->category);

		$this->redrawControl('categories');
	}

}