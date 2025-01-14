<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;

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
        try {
            Log::info('Fetching all users.');
            $users = $this->_userService->getAll();
            Log::info('Users fetched successfully.', ['user_count' => count($users)]);
            return view('users.index', compact('users'));
        } catch (\Exception $e) {
            Log::error('Error fetching all users.', ['error' => $e->getMessage()]);
            return response()->json(['message' => __('messages.user.fetch.failure')], 500);
        }
    }

    // Show form to create new user
    public function create()
    {
        Log::info('Rendering create user form.');
        return view('users.create');
    }

    // Store new user
    public function store(UserRequest $request)
    {
        try {
            Log::info('Attempting to create new user.', ['data' => $request->validated()]);
            $newUser = $this->_userService->createUser($request->validated());
            Log::info('New user created successfully.', ['user_id' => $newUser->id]);
            return response()->json(['message' => __('messages.user.create.success'), 'user' => $newUser]);
        } catch (\Exception $e) {
            Log::error('Failed to create new user.', ['error' => $e->getMessage()]);
            return response()->json(['message' => __('messages.user.create.failure')], 500);
        }
    }

    // Show form to edit user
    public function edit($id)
    {
        try {
            Log::info('Rendering edit user form.', ['user_id' => $id]);
            $user = $this->_userService->findUserById($id);
            return view('users.edit', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error rendering edit user form.', ['user_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => __('messages.user.edit.failure')], 500);
        }
    }

    // Update user
    public function update(UserRequest $request, $id)
    {
        try {
            Log::info('Attempting to update user.', ['user_id' => $id, 'data' => $request->validated()]);
            $user = $this->_userService->updateUser($request->validated(), $id);
            Log::info('User updated successfully.', ['user_id' => $user->id]);
            return response()->json(['message' => __('messages.user.update.success'), 'user' => $user]);
        } catch (\Exception $e) {
            Log::error('Failed to update user.', ['user_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => __('messages.user.update.failure')], 500);
        }
    }

    // Delete user
    public function destroy($id)
    {
        try {
            Log::info('Attempting to delete user.', ['user_id' => $id]);
            $this->_userService->deleteUser($id);
            Log::info('User deleted successfully.', ['user_id' => $id]);
            return response()->json(['message' => __('messages.user.delete.success'), 'id' => $id]);
        } catch (\Exception $e) {
            Log::error('Failed to delete user.', ['user_id' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => __('messages.user.delete.failure')], 500);
        }
    }

    // Search users by keyword
    public function searchByKeyword(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            Log::info('Searching users by keyword.', ['keyword' => $keyword]);
            $users = $this->_userService->searchByKeyword($keyword);
            Log::info('Search completed successfully.', ['user_count' => count($users)]);
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            Log::error('Error during user search.', ['error' => $e->getMessage()]);
            return response()->json(['message' => __('messages.user.search.failure')], 500);
        }
    }
}
