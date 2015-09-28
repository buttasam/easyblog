<?php

namespace App\FrontModule\Presenters;

use App\Model\Repository\ArticleRepository;
use App\Model\Repository\CategoryRepository;
use App\Model\Repository\CommentRepository;
use App\Model\Repository\UserRepository;
use Nette;
use Nette\Application\UI\Form;


class ArticlePresenter extends BasePresenter
{

	/** @var ArticleRepository */
	private $articles;

	/** @var  CommentRepository */
	private $comments;

	/** @var UserRepository */
	private $users;

	/** @var CategoryRepository */
	private $categories;


	/** @var \App\Model\Entity\Article */
	private $article = NULL;

	/** @var \App\Model\Entity\Comment */
	private $comment = NULL;


	public function __construct(ArticleRepository $articles, CommentRepository $comments, UserRepository $users, CategoryRepository $categories)
	{
		parent::__construct();

		$this->articles = $articles;
		$this->comments = $comments;
		$this->users = $users;
		$this->categories = $categories;
	}


	public function actionDefault($articleId = NULL)
	{
		if ($articleId !== NULL) {
			$this->authorize();
			$this->article = $this->articles->getByID($articleId);
			$this->checkRecord($this->article);

			$this['articleForm']->setDefaults([
				'title' => $this->article->getTitle(),
				'content' => $this->article->getContent(),
			]);
		}

		$this->template->articles = $this->articles->findAll();
	}


	public function actionDetail($articleId)
	{
		$this->article = $this->articles->getByID($articleId);
		$this->checkRecord($this->article);
	}


	/** @return void */
	public function renderDetail($articleId)
	{
		$articleCategories = $this->article->getAllCategories();
		$articleNotCategories = $this->articles->getNotCategories($this->article, $this->categories->findAll());
		$articleComments = $this->article->getAllComments();

		$this->template->article = $this->article;
		$this->template->articleCategories = $articleCategories;
		$this->template->articleComments = $articleComments;
		$this->template->articleNotCategories = $articleNotCategories;
	}


	protected function createComponentArticleForm()
	{
		$form = new Form;
		$form->addText('title', 'Titulek');
		$form->addTextArea('content', 'Obsah:');

		$form->addSubmit('send', 'Send');
		$form->onSuccess[] = $this->processArticleForm;

		return $form;
	}


	public function processArticleForm(Form $form, $values)
	{
		if ($this->article === NULL) {
			$article = $this->articles->createEntity();

		} else {
			$article = $this->article;
		}

		$article->setTitle($values->title);
		$article->setContent($values->content);

		$this->articles->persist($article);

		$this->redirect('default');
	}


	protected function createComponentCommentForm()
	{
		$form = new Form();
		$form->addTextArea('message');
		$form->addSubmit('send', 'Send');
		$form->onSuccess[] = $this->processCommentForm;

		return $form;
	}


	public function processCommentForm(Form $form, $values)
	{
		$this->comment = $this->comments->createEntity();
		$user = $this->users->getByID($this->getUser()
										   ->getId());

		$this->comment->setMessage($values->message);
		$this->comment->setArticle($this->article);
		$this->comment->setUser($user);

		$this->comments->persist($this->comment);
		$this->redirect('this');
	}


	public function handleDeleteArticle($id)
	{
		$this->article = $this->articles->getByID($id);

		$this->articles->delete($this->article);
		$this->redrawControl('articles');
	}


	public function handleDeleteComment($commentId)
	{
		$this->comment = $this->comments->getByID($commentId);
		$this->comments->delete($this->comment);

		$this->redrawControl('comments');
	}


	public function handleAddCategoryToArticle($articleId, $categoryId)
	{
		$this->articles->addArticleToCategory($articleId, $categoryId);
		$this->redrawControl('categoriesEdit');
	}


	public function handleDeleteCategoryFromArticle($articleId, $categoryId)
	{
		$this->articles->deleteArticleFromCategory($articleId, $categoryId);
		$this->redrawControl('categoriesEdit');
	}

}
