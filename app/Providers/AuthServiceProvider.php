<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session; 

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
       

        $this->registerPolicies();
        
        // if(!$this->app->routeAreCached())
        // {
            // Passport::routes();
        // }
        
        // Passport::routesForAuthorization();

        Gate::define('permission', function($user, $permission){
            $employee = Cache::remember('employee', 60*60*60, function () use ($user) {
                return User::with('person','employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access')->where('person_id', $user->person_id)->first();
            });
            $accesses = Cache::remember('accesses', 60*60*60, function () use ($employee) {
                return $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->access_list;
            });
            $accesses_status = Cache::remember('accesses_status', 60*60*60, function () use($employee) {
                return $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->status;
            });

            $check = ($employee)? unserialize($accesses) : null;

            if($check != null){
                return in_array($permission,  unserialize($accesses)) && $accesses_status == '1';
            }else{
                return false;
            }
        });

        // Gate::define('permission', function ($user, $permission, $userId = null) {
        //     $userId = $user->person_id;
        
        //     $employee = Cache::remember("employee_$userId", 60 * 60 * 60, function () use ($user) {
        //         return User::with('person', 'employee.employeeHasPosition.employeePositionHasPermissionAccess.permissionHasAccess.access')->where('person_id', $user->person_id)->first();
        //     });
        
        //     $accesses = Cache::remember("accesses_$userId", 60 * 60 * 60, function () use ($employee) {
        //         return $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->access_list;
        //     });
        
        //     $accessesStatus = Cache::remember("accesses_status_$userId", 60 * 60 * 60, function () use ($employee) {
        //         return $employee->employee->employeeHasPosition->employeePositionHasPermissionAccess->permissionHasAccess->access->status;
        //     });
        
        //     $check = ($employee) ? unserialize($accesses) : null;
        
        //     if ($check != null) {
        //         return in_array($permission, unserialize($accesses)) && $accessesStatus == '1';
        //     } else {
        //         return false;
        //     }
        // });

        //
    }
}
