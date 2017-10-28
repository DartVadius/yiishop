<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 06.09.17
 * Time: 20:25
 */

namespace core\services\management;


use core\entities\characteristic\Characteristic;
use core\forms\management\characteristic\CharacteristicForm;
use core\repository\CharacteristicRepository;

class CharacteristicManagementService {
    private $characteristicRepository;

    public function __construct(CharacteristicRepository $repository) {
        $this->characteristicRepository = $repository;
    }

    public function create(CharacteristicForm $form) {
        $characteristic = Characteristic::create(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->getVariants(),
            $form->sort
        );
        $this->characteristicRepository->save($characteristic);
        return $characteristic;
    }
    public function edit($id, CharacteristicForm $form) {
        /** @var Characteristic $characteristic */
        $characteristic = $this->characteristicRepository->getById($id);
        $characteristic->edit(
            $form->name,
            $form->type,
            $form->required,
            $form->default,
            $form->getVariants(),
            $form->sort
        );
        $this->characteristicRepository->save($characteristic);
    }
    public function remove($id) {
        $characteristic = $this->characteristicRepository->getById($id);
        $this->characteristicRepository->delete($characteristic);
    }
}