<?php

/**
 * Created by PhpStorm.
 * User: samik
 * Date: 21.9.15
 * Time: 1:16
 */

namespace App\Model\Entity;

use App\Model\Entities\BaseEntity;
use Nette\PhpGenerator\ClassType;
use YetORM\Entity;
use YetORM\EntityCollection;


class Category extends BaseEntity
{

	/** @return int */
	public function getID()
	{
		return $this->record->id;
	}


	/** @return string */
	public function getTitle()
	{
		return $this->record->title;
	}


	/**
	 * @param  string $title
	 * @return Category
	 */
	public function setTitle($title)
	{
		$this->record->title = (string) $title;
		return $this;
	}


	/** @return string */
	public function getURL()
	{
		return $this->record->url;
	}


	/**
	 * @param  string $url
	 * @return Category
	 */
	public function setURL($url)
	{
		$this->record->url = (string) $url;
		return $this;
	}


	/** @return \DateTime */
	public function getCreatedAt()
	{
		return $this->record->created_at;
	}


	/**
	 * @param  \DateTime $date
	 * @return Category
	 */
	public function setCreatedAt(\DateTime $date)
	{
		$this->record->created_at = $date;
		return $this;
	}


	/**
	 * @return EntityCollection
	 */
	public function getAllArticles()
	{
		$selection = $this->record->related('article_in_category');
		return new EntityCollection($selection, Article::class, 'article');
	}

}
