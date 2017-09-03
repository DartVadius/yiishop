<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 02.09.17
 * Time: 14:50
 */

namespace core\services\management;

use core\entities\tag\Tag;
use core\forms\management\user\TagForm;
use core\repository\TagRepository;
use yii\helpers\Inflector;


class TagManagementService {
    private $tagRepository;

    public function __construct(TagRepository $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    public function create(TagForm $tagForm) {
        $tag = Tag::create(
            $tagForm->name,
            $tagForm->slug ? $tagForm->slug : Inflector::slug($tagForm->name)
        );
        $this->tagRepository->save($tag);
        return $tag;
    }

    public function edit($id, TagForm $tagForm) {
        $tag = $this->tagRepository->getById($id);
        $tag->edit($tagForm->name, $tagForm->slug ? $tagForm->slug : Inflector::slug($tagForm->name));
        $this->tagRepository->save($tag);
    }

    public function delete($id) {
        $tag = $this->tagRepository->getById($id);
        $this->tagRepository->delete($tag);
    }
}