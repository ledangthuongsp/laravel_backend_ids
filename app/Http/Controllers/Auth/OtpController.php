<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OtpController extends Controller{
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        // Lưu OTP vào database
        DB::table('password_resets_otp')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        // Gửi OTP qua email
        Mail::raw("Your OTP code is: $otp", function ($message) use ($request) {
            $message->to($request->email)
                    ->subject('Password Reset OTP');
        });

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp'   => 'required|digits:6'
        ]);

        $record = DB::table('password_resets_otp')
            ->where('email', $request->email)
            ->where('otp', $request->otp)
            ->first();

        if (!$record || Carbon::now()->greaterThan($record->expires_at)) {
            return response()->json(['message' => 'Invalid or expired OTP.'], 400);
        }

        // Xóa OTP sau khi xác nhận
        DB::table('password_resets_otp')->where('email', $request->email)->delete();

        return response()->json(['message' => 'OTP verified. You can now reset your password.']);
    }
    public function resetPassword(Request $request)
{
    $request->validate([
        'email'    => 'required|email|exists:users,email',
        'password' => 'required|string|min:8|confirmed'
    ]);

    $user = User::where('email', $request->email)->first();
    $user->password = bcrypt($request->password);
    $user->save();

    return response()->json(['message' => 'Password has been reset successfully.']);
}

}