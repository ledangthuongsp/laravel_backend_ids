<?php
namespace App\Repositories\IRepository;
interface IUserRepository 
{
    public function getAll();

    public function findUserById($id);

    public function createUser(array $data);

    public function updateUser(array $data, $id);

    public function deleteUser($id);

    public function searchByKeyword($keyword);
}