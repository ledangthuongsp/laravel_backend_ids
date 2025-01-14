<?php
namespace App\Repositories;

use App\Repositories\IRepository\IRoleRepository;
use App\Models\Role;
use App\Common\Constants\Constant;

class RoleRepository implements IRoleRepository
{
    protected $_model;
    public function __construct()
    {
        $this->_model = app()->make(Role::class);
    }
    public function getAllRole()
    {
        $roles = $this->_model::simplePaginate(Constant::PAGINATE_DEFAULT);
        return $roles;
    }
    public function findRoleById($id)
    {
        $roles = $this->_model::find($id);
        return $roles;
    }
    public function createRole(array $data){
        $newRole = $this->_model::create([
            'role' => $data['role'], // Thêm role khi tạo mới
        ]);
        return $newRole;
    }
    public function updateRole(array $data, $id){
        $roles = $this->_model::find($id);
        $roles->role_type = $data['role_type'];
        $roles->save();
        return $roles;

    }
    public function deleteRole($id)
    {   
        $roles = $this->_model::find($id);
        $roles->delete();
        return $roles;
    }
    public function searchRoleByKeyword($keyword)
    {
        $roles = [];
        if (is_null($keyword) || $keyword === '')
            $roles = $this->_model->get();
        else 
            $roles = $this->_model::where('role_type', 'LIKE', $keyword)->get();
                        
        return $roles;
    }
}