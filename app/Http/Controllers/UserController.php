<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $users = User::get();
        return view('taikhoan.index', compact('users'));
    }

    public function show()
    {
        return view('auth.profile');
    }

    public function changeRole($id)
    {
        $user = User::findOrFail($id);
        $user->role_id == 1 ? $user->role_id = 0 : $user->role_id = 1;

        $user->save();

        Alert::success('Thành công', 'Thay đổi role thành công!');
        return back();
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);
        return view('taikhoan.show', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'old_password.required' => 'Mật khẩu cũ không được để trống!',
            'password.required' => 'Mật khẩu mới không được để trống!',
            'password.min' => 'Bạn phải nhập ít nhất 8 kí tự!'
        ]);

        $user = Auth::user();

        if (Hash::check($request->old_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->password)
            ]);

            Auth::logout();

            Alert::success('Thành công', 'Thay đổi mật khẩu thành công thành công. Xin vui lòng đăng nhập lại!');
            return redirect()->route('login');
        }

        return back()->withErrors(['old_password' => 'Mật khẩu cũ bạn vừa nhập không chính xác!']);
    }


    public function updateProfile(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'dia_chi' => 'max:255',
                'sdt' => 'nullable|regex:/^(0)[0-9]{9}$/',
                'change_img' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            [
                'name.required' => 'Tên không được bỏ trống',
                'name.string' => 'Tên phải là chuỗi',
                'name.max' => 'Tên không được vượt quá :max ký tự',
                'dia_chi.max' => 'Địa chỉ không được vượt quá :max ký tự',
                'sdt.regex' => 'Số điện thoại không đúng định dạng',
                'change_img.image' => 'Ảnh đại diện phải là hình ảnh',
                'change_img.mimes' => 'Ảnh đại diện chỉ được chấp nhận các định dạng: :values',
                'change_img.max' => 'Ảnh đại diện không được vượt quá :max KB',
            ]
        );

        $user = auth()->user();
        $file_name = auth()->user()->avatar;

        if ($request->hasFile('change_img') && $file_name != $request->change_img) {
            $img = $request->file('change_img');
            $user->avatar = time() . '.' . $img->getClientOriginalExtension();
            $path = $request->file('change_img')->storeAs('public/images/user', $user->avatar);
        }

        $status = $user->update([
            'name' => $request->name,
            'dia_chi' => $request->dia_chi,
            'avatar' => $file_name,
            'sdt' => $request->sdt,
            'gioi_tinh' => $request->gioi_tinh
        ]);

        if ($status) {
            Alert::success('Thành công', 'Thay đổi thông tin cá nhân thành công!');
            return back();
        } else {
            if ($request->hasFile('change_img') && $file_name != $request->change_img && $file_name != 'avatar.jpg') {
                unlink(storage_path('app/public/images/user' . $file_name));
            };

            Alert::error('Thất bại', 'Thay đổi thông tin cá nhân thất bại. Vui lòng kiểm tra lại thông tin bạn vừa nhập!')->autoClose(5000);
            return back();
        }
    }


    public function delete($id)
    {
        User::destroy($id);

        Alert::success('Thành công', 'Xóa tài khoản thành công!');
        return back();
    }
}
