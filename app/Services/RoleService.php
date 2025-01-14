<?php
namespace App\Services;
use App\Repositories\RoleRepository;
class RoleService {
    protected RoleRepository $_roleRepository;

    public function __construct(RoleRepository $roleRepository)
    {
        $this->_roleRepository = $roleRepository;
    }
    public function getAllRole()
    {
        return $this-> _roleRepository->getAllRole();
    }
    public function findRoleById($id)
    {
        return $this->_roleRepository->findRoleById($id);
    }
    public function createRole(array $data)
    {
        return $this->_roleRepository->createRole($data);
    }
    public function updateRole(array $data, $id){
        return $this->_roleRepository->updateRole($data, $id);
    }
    public function deleteRole($id)
    {
        return $this->_roleRepository->deleteRole($id);
    }
    public function searchRoleByKeyword($keyword)
    {
        return $this->_roleRepository->searchRoleByKeyword($keyword);
    }
}