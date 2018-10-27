<?php
namespace App\Services;
use Illuminate\Support\Facades\Auth;

class UserFac {
  public function getUsername() {
    return Auth::user()->name;
  }
  public function getEmail() {
    return Auth::user()->email;
  }
  public function getUserRole() {
    return 'Admin';
  }
}