<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\CodeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SendCodeRecoveryPasswordRequest;
use App\Http\Requests\SignUpRequest;
use App\Mail\PasswordResetMail;
use App\Models\Password_reset;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Monolog\Logger;

class AuthController extends Controller
{
    public function sign_up(SignUpRequest $request){

        /*$validator = Validator::make($request->all(), [

        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }*/
        /*$exist_user_by_email = User::where("email", '=', $data['email'])->exists();
        if($exist_user_by_email)
        {
            return response()->json(["error"=>"Пользователь с email - адресом ".$data['email']." уже существует"], 409);
        }*/
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('apiToken')->plainTextToken;
        return response()->json(["token"=>$token], 201);
    }
    public function login(LoginRequest $request)
    {
        $user = User::where('email',"=", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response(["status"=>false, 'message' => __("messages.incorrect_email_password")], 401);
        }
        $token = $user->createToken('apiToken')->plainTextToken;
        return response()->json(['token' => $token], 201);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    public function checkUserAuth(Request $request)
    {
        return response()->json(["result_check_auth_user"=>Auth::check()]);
    }
    public function send_code_recover_password(SendCodeRecoveryPasswordRequest $request)
    {
        logger("Отправка кода сброса пароля");
        logger("Пункт 1");
        $user = User::where("email", "=", $request->input("email"))->select(["name", "id"])->first();
        logger("Пункт 2");
        $randomResetCode = str(mt_rand(100000, 999999));
        logger("Пункт 3");
        logger($randomResetCode);
        // TODO не работает отправка сообщений на почту через Яндекс
        //Mail::to($request->input("email"))->send(new PasswordResetMail($user->name, $randomResetCode));
        logger("Пункт 4");
        Password_reset::query()->where("user_id", "=",$user->id)->update(["confirmed"=>true, "change_password"=>true]);
        logger("Пункт 5");
        $password_reset = new Password_reset();
        $password_reset->recovery_code = bcrypt($randomResetCode);
        $password_reset->user_id = $user->id;
        $password_reset->save();
        logger("Пункт 6");
        return response()->json(["message"=>__("messages.message_set_error_code")]);
    }
    public function checkValidCode(CodeRequest $request)
    {
        $user_id = User::where("email", "=", $request->email)->first()->id;
        $code_info = Password_reset::query()->where("user_id", "=",$user_id)
            ->where("confirmed","=", false)
            ->where("change_password","=", false)
            ->latest()
            ->first();
        logger($code_info);
        if($code_info == null)
        {
            return response()->json(["type"=>"code_not_found",
                "error"=>__("messages.request_change_code_not_found", ["email" => $request->email])],404);
        }
        $hash_code = $code_info->recovery_code;
        if (!Hash::check($request->code, $hash_code)) {
            return response()->json(["type"=>"not_valid_code",
                "error"=>__("messages.not_valid_change_password_code", ["email" => $request->email])],400 );
        }
        $code_info->update(["confirmed"=>true]);
        return response()->json(["message"=>"Код был подтвержден и больше не действителен."]);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::where("email", "=", $request->email)->first();
        $code_info = Password_reset::query()->where("user_id", "=",$user->id)
            ->where("confirmed","=", true)
            ->where("change_password","=",false)
            ->latest()->first();
        if($code_info == null)
        {
            return response()->json(["type"=>"code_not_found",
                "error"=>__("messages.not_found_confirmed_code_with_not_changed_password")],404);
        }
        $hash_code = $code_info->recovery_code;
        if (!Hash::check($request->code, $hash_code)) {
            return response()->json(["type"=>"not_valid_code",
                "error"=>__("messages.not_valid_change_password_code", ["email" => $request->email])],400);
        }
        if(Hash::check($request->password, $user->password))
        {
            return response()->json(["type"=>"previous_password",
                "error"=>__("messages.previous_password", ["email" => $request->email])],400);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        Password_reset::query()->where("user_id", "=",$user->id)->delete();
        return response()->json(["message"=>__("messages.success_change_password")]);
    }
}
