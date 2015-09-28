<?php

/**
 * Created by PhpStorm.
 * User: samik
 * Date: 21.9.15
 * Time: 1:21
 */

namespace App\Model\Repository;

use YetORM\EntityCollection;
use YetORM\Repository;
use \App\Model\Entity\Article;


/**
 * @table article
 * @entity Article
 */
class ArticleRepository extends Repository
{
	/**
	 * @param Article $article
	 */
	public function getNotCategories(Article $article, EntityCollection $categories)
	{
		/** @var array() $result */
		$results = $categories->toArray();

		foreach ($results as $key => $result) {
			foreach ($article->getAllCategories() as $articleCategory) {
				if ($articleCategory->getID() == $result->getId())
					unset($results[$key]);
			}
		}

		return $results;
	}


	/**
	 * @param int $articleId
	 * @param int $categoryId
	 */
	public function addArticleToCategory($articleId, $categoryId)
	{
		$this->database->table('article_in_category')
					   ->insert(array(
						   'article_id' => $articleId,
						   'category_id' => $categoryId
					   ));
	}


	/**
	 * @param int $articleId
	 * @param int $categoryId
	 */
	public function deleteArticleFromCategory($articleId, $categoryId)
	{
		$this->database->table('article_in_category')
					   ->where(array(
						   'article_id' => $articleId,
						   'category_id' => $categoryId
					   ))
					   ->delete();
	}

}
