<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
    protected UserService $_userService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserService $userService)
    {
        $this->middleware('auth');
        $this->_userService = $userService;
    }

    // Show all users
    public function index()
    {
        $users = $this->_userService->getAll();
        return view('users.index', compact('users'));
    }

    // Show form to create new user
    public function create()
    {
        return view('users.create');
    }

    // Store new user
    public function store(UserRequest $request)
    {   
        $newUser = $this->_userService->createUser($request->validated());
        return response()->json(['message' => __('messages.user.create.success'), 'user' => $newUser]);
    }

    // Show form to edit user
    public function edit($id)
    {
        $user = $this->_userService->findUserById($id);
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(UserRequest $request, $id)
    {
        $user = $this->_userService->updateUser($request->validated(), $id);
        return response()->json(['message' => __('messages.user.update.success'), 'user' => $user]);
        // return redirect()->route('users.index')->with("success", __('messages.user.update.success'));
    }

    // Delete user
    public function destroy($id)
    {
        $this->_userService->deleteUser($id);
        return response()->json(['message' =>  __('messages.user.delete.success'), 'id' => $id]);
    }

    public function searchByKeyword(Request $request)
    {
        $keyword = $request->input('keyword');
        $users = $this->_userService->searchByKeyword($keyword);
        return response()->json(['users' => $users]);
        // return $users;
    }
}