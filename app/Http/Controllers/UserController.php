<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
    
    public function editAvatar(Request $request)
    {
        // Validate ảnh tải lên
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Lấy người dùng hiện tại
        $user = Auth::user(); // Dùng Auth::user() thay vì auth()::user()

        // Kiểm tra nếu người dùng không đăng nhập
        if (!$user) {
            return redirect()->route('login')->with('error', 'Bạn phải đăng nhập trước!');
        }

        // Upload avatar lên Cloudinary
        $image = $request->file('avatar');
        $uploadedImage = Cloudinary::upload($image->getRealPath(), [
            'folder' => 'avatars'
        ]);

        // Lưu URL của avatar vào cơ sở dữ liệu
        try {
            // Đảm bảo là một đối tượng User
            $user->avatarUrl = $uploadedImage->getSecurePath();
            $user->Auth::save();
        } catch (\Exception $e) {
            return back()->with('error', 'Đã có lỗi xảy ra: ' . $e->getMessage());
        }

        return back()->with('success', 'Avatar đã được cập nhật thành công!');
    }


    public function dashboard()
    {
        $users = User::all(); // Lấy tất cả người dùng trong hệ thống

        return view('dashboard', compact('users'));
    }
    public function updateAvatar(Request $request)
{
    $request->validate([
        'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $user = Auth::user();

    if ($request->hasFile('avatar')) {
        $image = $request->file('avatar');
        $uploadedImage = Cloudinary::upload($image->getRealPath(), [
            'folder' => 'avatars',
        ]);

        // Cập nhật URL của avatar vào database
        $user->avatarUrl = $uploadedImage->getSecurePath();
        $user->Auth::save();
    }

    return back()->with('success', 'Avatar đã được cập nhật thành công!');
}
}
