<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Power; // 权限表
use App\Model\Role; // 角色
use App\Model\RolePower; // 权限角色关系表

class RoleController extends Controller
{
    // 添加展示
    public function index(){
        $powerInfo=Power::get()->toArray();
        $powerInfo=CreatPower($powerInfo);
        return view('admin.role.index',['powerInfo'=>$powerInfo]);
    }

    // 执行添加
    public function add(){
        $data=request()->except('_token');
        $roleInfo=Role::create(['role_name'=>$data['role_name']]);
        $role_id=$roleInfo->role_id;
        $role=[];
        foreach ($data['power_id'] as $v){
            $role[]=[
                'role_id'=>$role_id,
                'power_id'=>$v,
            ];
        }
        $res=RolePower::insert($role);
        if($res){
            return redirect('Role/show');
        }
    }

    // 列表展示
    public function show(){
        $roleInfo=Role::get()->toArray();
        foreach($roleInfo as $k=>$v){
            $powerInfo=RolePower::join('power','role_power.power_id','=','power.power_id')
                                ->where(['role_id'=>$v['role_id']])
                                ->get()
                                ->toArray();
            $roleInfo[$k]['power']=$powerInfo;
        }
        
        return view('admin.role.show',['roleInfo'=>$roleInfo]);
    }
}
