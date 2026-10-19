<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\LoginModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index(){
              
    }

    public function userlist(){
                $user_lists = LoginModel::all();
                return view('users_list')->with(compact('user_lists'));
    }

    public function login(Request $request)
    {
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required|string|min:8',
                ]);
                $user = User::where('email', $request->email)->first();
                if (!$user || !Hash::check($request->password, $user->password)) {
                    return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
                    }
                session(['username' => $user->email]);
                session(['login_id' => $user->login_id]);
                   if ($user->role == 'admin') {
                    session()->put('role', 'admin');
                    session()->flash('success', 'Admin Login Successfully..');
                     return redirect()->route('quiz.editor.index');
                 } else {
                    session()->put('role', 'user');
                    session()->flash('success', 'User Login Successfully..');
                    return redirect()->route('quiz.useradmin.index');
                }
    }


    public function store(Request $request)
{
    // Sanitize inputs (trim and make email lowercase)
    $username = preg_replace('/\s+/', ' ', trim($request->username)); // Remove extra spaces
    $email = strtolower(trim($request->email)); // Trim and convert email to lowercase

    // Validate inputs
    $request->validate([
        'username' => 'required|string|min:3|max:255|regex:/^\S+$/', // No spaces in username
        'email' => 'required|email|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/|unique:users,email', // Email validation with regex
        'password' => 'required|string|min:8|regex:/^\S*$/', // No spaces in password
    ], [
        'email.regex' => 'The email format is invalid. Ensure there is only one "@" and no dots directly after "@" or at the end.',
        'email.unique' => 'This email is already registered!',
        'username.regex' => 'Username should not have spaces.',
        'password.regex' => 'Password should not have spaces.',
    ]);

    try {
        $information = new LoginModel();
        $information->username = $username;
        $information->email = $email;
        $information->password = Hash::make($request->password);
        $information->role = $request->role;
        $information->save();

        session()->flash('success', 'Registration successful!');
        return redirect()->route('user.details')->with('success', 'User registered successfully!');

    } catch (\Illuminate\Database\QueryException $e) {
        if ($e->getCode() == 23000) {
            return redirect()->route('user.details')->with('error', 'This email is already registered!');
        }
        return redirect()->route('user.details')->with('error', 'Something went wrong. Please try again!');
    }
}



    public function edit($id){
                $edit_users = LoginModel::find($id);
                return view('edit-user')->with(compact('edit_users'));

    }

    public function update(Request $request, $id)
{
    $information = LoginModel::find($id);

    $username = preg_replace('/\s+/', ' ', trim($request->username));

    $email = strtolower(trim($request->email));

    $request->validate([
        'username' => 'required|string|min:3|max:255|regex:/^\S+$/',
        'email' => 'required|email|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/|unique:users,email,' . $id,
    ], [
        'email.regex' => 'The email format is invalid. Ensure there is only one "@" and no dots directly after "@" or at the end.',
        'email.unique' => 'This email is already registered!',

    ]);

    // Update the user's information
    $information->username = $username;
    $information->email = $email;
    $information->role = $request->role;

    $information->save();

    return redirect()->route('user.details')->with('success', 'User details updated successfully!');
}


    public function update_password(Request $request, $id) {
                $request->validate([
                'new_password' => 'required|string|min:8|regex:/^\S*$/',
                ], [
                    'new_password.regex' => 'The password field format is invalid',
                ]);

                $information = LoginModel::find($id);
                $information->password = Hash::make($request->new_password);
                $information->save();

                session()->flash('success', 'Password Change successful!');

                return redirect()->route('user.details')->with('success', 'Password Change successfully!');
    }

    public function destroy($id){
                $user = LoginModel::find($id);
                $user->delete();
                return redirect()->route('user.details');
    }

    public function logout(){
                session()->flush();
                return redirect()->route('quiz.useradmin.index');
    }



}


