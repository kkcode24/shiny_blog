<?php
declare(strict_types=1);
namespace Nekudo\ShinyBlog\Domain;

use Nekudo\ShinyBlog\Exception\NotFoundException;
use Nekudo\ShinyBlog\Domain\Entity\ArticleEntity;

class ShowArticleDomain extends ContentDomain
{
    /**
     * Loads article data by given slug.
     *
     * @param string $slug
     * @throws NotFoundException
     * @return ArticleEntity
     */
    public function getArticleBySlug(string $slug) : ArticleEntity
    {
        $this->loadArticleMeta('slug');
        if (!isset($this->articleMeta[$slug])) {
            throw new NotFoundException('Article not found.');
        }
        $articleData = $this->parseContentFile($this->articleMeta[$slug]['file']);
        $article = new ArticleEntity($this->config);
        $article->setContent($articleData['content']);
        $article->setMeta($articleData['meta']);
        return $article;
    }
}