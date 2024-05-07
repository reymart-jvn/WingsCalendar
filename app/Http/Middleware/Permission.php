<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $actions = array_slice(func_get_args(), 2);
        
        foreach($actions as $action){
        // $employee = User::with('person','employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access')->where('person_id',Auth::user()->person_id)->first();
        // $accesses =  $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->access_list;
        // $accesses_status =  $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->status; 
        $employee = Cache::remember('per_employee', 60*60*60, function (){
            return User::with('person','employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access')->where('person_id',Auth::user()->person_id)->first();
        });
        $accesses = Cache::remember('per_accesses', 60*60*60, function () use ($employee) {
            return $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->access_list;
        });
        $accesses_status = Cache::remember('per_accesses_status', 60*60*60, function () use($employee) {
            return $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->status;
        });
        
            $check = ($employee)? unserialize($accesses) : null;

            if($check != null){
                if(in_array($action, unserialize($accesses)) && $accesses_status == '1'){
                    return $next($request);
                }
            }
        }
        abort(403);
        return $next($request);
    }
}
