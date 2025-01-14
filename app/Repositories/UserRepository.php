<?php
namespace App\Repositories;
use App\Repositories\IRepository\IUserRepository;
use App\Common\Constants\Constant;
use Illuminate\Support\Facades\Hash;
class UserRepository implements IUserRepository 
{
    protected $_model;

    // constructor
    public function __construct() {
        $this->_model = app()->make(\App\Models\User::class);
    }

    // implement interface function
    public function getAll() {
        $users = $this->_model::simplePaginate(Constant::PAGINATE_DEFAULT);
        return $users;
    }

    public function findUserById($id) {
        $user = $this->_model::find($id);
        return $user;
    }

    public function createUser(array $data) {
        $imagePath = "";
        if (isset($data['avatar']) && $data['avatar']) {
            $image = $data['avatar'];
            $imagePath = $image->store('/images', 'public');
        }

        $newUser = $this->_model::create([
            'avatar' => $imagePath,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']) // mã hóa mật khẩu
        ]);

        return $newUser;
    }

    public function updateUser(array $data, $id) {
        $user = $this->_model::find($id);

        // lưu file avatar
        $imagePath = $user->avatar;
        if (isset($data['avatar']) && $data['avatar']) {
            $image = $data['avatar'];
            $imagePath = $image->store('/images', 'public');
        }
        
        $user->avatar = $imagePath;
        $user->name = $data['name'];
        $user->email = $data['email'];

        // mã hóa mật khẩu vừa tạo
        if ($data['password']) {
            $user->password = Hash::make($data['password']);
        }
        $user->save();
        return $user;
    }

    public function deleteUser($id) {
        $user = $this->_model::find($id);
        $user->delete();
    }

    public function searchByKeyword($keyword) {
        $users = [];
        if (is_null($keyword) || $keyword === '')
            $users = $this->_model->get();
        else 
            $users = $this->_model::where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhere('email', 'LIKE', '%' . $keyword . '%')->get();
                        
        return $users;
    }
}