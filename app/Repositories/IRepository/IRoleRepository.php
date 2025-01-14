<?php
namespace App\Repositories\IRepository;

interface IRoleRepository{
    public function getAllRole();
    public function findRoleById($id);
    public function createRole(array $data);
    public function updateRole(array $data, $id);
    public function deleteRole($id);
    public function searchRoleByKeyword($keyword);
}