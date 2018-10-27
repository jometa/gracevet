<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    //
  public function doLogin(Request $request) {
    // validate the info, create rules for the inputs
    $rules = array(
      'email'    => 'required|email', // make sure the email is an actual email
      'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
    );
    
    $this->validate($request, $rules);
    // echo 'FOOBAR';
    
    $userdata = array(
      'email' => $request->email,
      'password' => $request->password
    );
    if (Auth::attempt($userdata)) {
      // Authentication passed...
      return redirect()->intended('/');
      // return 'GOOD';
    } else  {
      return 'BAD';
    }
  }

  public function logOut() {
    Auth::logout();
    return redirect('/login');
  }
}