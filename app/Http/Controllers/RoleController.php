<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\User;
use App\Models\menu_sub;


use Illuminate\Http\Request;
use App\Models\menu_permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
  public function role()
  {
    if (Auth::user()->role == '3') {
      $viewdata['user'] = User::whereIn('role', [1, 2])->get();
      $viewdata['menu'] = menu::all();
      $viewdata['menu_sub'] = menu_sub::all();
      return view('role.role', $viewdata);
    }else{
      return redirect()->route('home')->with('msg', 'Cannot Access page!');

    }
  }

  public function permission(Request $request)
  {
    $alreadyper = menu_permission::where('user_id', $request->employee)->get();
    $count = $alreadyper->count();
    if ($count == 0) {
      foreach ($request->permissions as $val) {
        $per = explode("-", $val);
        menu_permission::create([
          'user_id' => $request->employee,
          'menu' => $per[0],
          'menu_sub' => $per[1],
        ]);
      }
    } else {
      // menu_permission::where('user_id', $request->employee)->delete();
      foreach ($alreadyper as $val) {
        $val->delete();
      }
      foreach ($request->permissions as $val) {
        $per = explode("-", $val);
        menu_permission::create([
          'user_id' => $request->employee,
          'menu' => $per[0],
          'menu_sub' => $per[1],
        ]);
      }
    }
    return redirect()->back()->with('msg', 'Permission Created Successfully!');
  }
  public function check_emp(Request $request)
  {
    $per =  menu_permission::select('menu_sub', 'menu')->where('user_id', $request->id)->get();
    $id = $request->id;
    return response()->json(['success' => '1', 'per' => $per, 'id' => $id]);
  }
  public function menu()
  {
    menu::truncate();
    return response()->json(['success' => '1', 'menu' => 'Main menu  truncate successfully!']);
  }
  public function sub_menu()
  {
    menu_sub::truncate();
    menu_permission::truncate();
    return response()->json(['success' => '1', 'menu_sub' => 'menu sub truncate successfully!']);
  }
  public function permission_menu()
  {
    menu_permission::truncate();
    return response()->json(['success' => '1', 'menu_sub' => 'menu sub truncate successfully!']);
  }
}
