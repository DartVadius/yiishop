<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 07.09.17
 * Time: 20:05
 */

namespace core\forms\management\product;


use yii\base\Model;
use yii\web\UploadedFile;

class PhotoForm extends Model {

    /**
     * @var UploadedFile[]
     */
    public $files;

    public function rules() {
        return [
            ['files', 'each', 'rule' => ['image']],
        ];
    }

    public function beforeValidate() {
        if (parent::beforeValidate()) {
            $this->files = UploadedFile::getInstances($this, 'files');
        }
        return false;
    }

}