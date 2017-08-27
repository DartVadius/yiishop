<?php
/**
 * Created by PhpStorm.
 * User: dartvadius
 * Date: 27.08.17
 * Time: 15:55
 */
namespace core\services\management;

use core\entities\user\User;
use core\forms\management\user\UserEditForm;
use core\repository\UserRepository;
use core\forms\management\user\UserCreateForm;


class UserManagementService {
    private $repository;
    public function __construct(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function create(UserCreateForm $form) {
        $user = User::createUser($form->username, $form->email, $form->password);
        $this->repository->save($user);
        return $user;
    }

    public function edit($id, UserEditForm $form) {
        $user = $this->repository->findById($id);
        $user->edit($form->username, $form->email);
        $this->repository->save($user);
    }
}