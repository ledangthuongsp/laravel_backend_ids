<?php
namespace App\Services;
use App\Http\Requests\UserRequest;
use App\Repositories\UserRepository;
class UserService {
    protected UserRepository $_userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->_userRepository = $userRepository;
    }

    public function getAll() {
        return $this->_userRepository->getAll();
    }

    public function createUser(array $data) {
        return $this->_userRepository->createUser($data);
    }

    public function findUserById($id) {
        return $this->_userRepository->findUserById($id);
    }

    public function updateUser(array $data, $id) {
        return $this->_userRepository->updateUser($data, $id);
    }

    public function deleteUser($id) {
        return $this->_userRepository->deleteUser($id);
    }

    public function searchByKeyword($keyword) {
        return $this->_userRepository->searchByKeyword($keyword);
    }
}