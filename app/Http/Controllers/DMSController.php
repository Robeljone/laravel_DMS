<?php

namespace App\Http\Controllers;

use App\Models\Folders;
use App\Models\FolderUsers;
use App\Models\User;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DMSController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function login_user(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            if (Hash::check($request->password, $user->password)) {
                session(['isAuth' => true]);
                session(['user' => $user]);
                session(['user_id' => $user->id]);
                Auth::login($user);

                return response()->json(['message' => 'Login success'], 200, []);
            } else {
                return response()->json(['message' => 'Login Faild'], 400, []);
            }
        } catch (Exception $e) {
            Log::debug($e);

            return response()->json($e->getMessage(), 400, []);
        }
    }

    public function logout_user(Request $request)
    {
        try {
            $request->session()->flush();

            return redirect('login');
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function roles_perm()
    {
        return view('roles');
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function folder_pg()
    {
        return view('folder');
    }

    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        return $this->loadDirectory($user_id);
    }

    /**
     * Display a specific directory and its content.
     */
    public function show(Request $request, $dir = null)
    {
        $base = 'documents';
        $r_p = str_replace('/','\\',$dir);
        $directory = "{$base}/{$dir}";
        $sub_dir = 'app/documents\\'.$r_p;
        $user_id = $request->session()->get('user_id');
        $parent_id = Folders::where('path',$sub_dir)->first();
        $folder_acc = $this->get_user_folder($user_id,$parent_id->id);
        $folder_given = [];

        foreach ($folder_acc as $fold) {
            if (count($fold) != 0) {
                array_push($folder_given, $fold[0]['name']);
            }
        }
        $directories = collect(Storage::directories($directory))->map(function ($path) use ($base) {
            return [
                'name' => basename($path),
                'path' => str_replace("{$base}/", '', $path),
            ];
        })->filter(function ($folder) use ($folder_given) {
            return in_array($folder['name'], $folder_given);
        })->values();

        $files = collect(Storage::files($directory))->map(function ($path) use ($base) {
            return [
                'name' => basename($path),
                'path' => str_replace("{$base}/", '', $path),
            ];
        })->filter(function ($folder) use ($folder_given) {
            return in_array($folder['name'], $folder_given);
        })->values();

        $breadcrumb = $this->buildBreadcrumb($dir, $base);

        return view('folder', [
            'directories' => $directories,
            'files' => $files,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    /**
     * Reusable method for loading folder structure.
     */
    private function loadDirectory($user_id, $dir = null)
    {
        $base = 'documents';
        $folder_given = [];
        $directory = $dir ? "{$base}/{$dir}" : $base;

        $access_folder = $this->get_user_folder($user_id);
        foreach ($access_folder as $fold) {
            if (count($fold) != 0) {
                $path = str_replace('app/documents\\', '', $fold[0]['path']);
                array_push($folder_given, $path);
            }
        }

        $directories = collect(Storage::directories($directory))->map(function ($path) use ($base) {
            return [
                'name' => basename($path),
                'path' => str_replace("{$base}/", '', $path),
            ];
        })->filter(function ($folder) use ($folder_given) {
            return in_array($folder['name'], $folder_given);
        })->values();

        $files = collect(Storage::files($directory))->map(function ($path) use ($base) {
            return [
                'name' => basename($path),
                'path' => str_replace("{$base}/", '', $path),
            ];
        })->filter(function ($folder) use ($folder_given) {
            return in_array($folder['name'], $folder_given);
        })->values();

        $breadcrumb = $this->buildBreadcrumb($dir, $base);

        return view('folder', [
            'directories' => $directories,
            'files' => $files,
            'breadcrumb' => $breadcrumb,
        ]);
    }

    /**
     * Build breadcrumb array for navigation
     */
    private function buildBreadcrumb($dir, $base)
    {
        if (! $dir) {
            return [];
        }

        $segments = explode('/', $dir);
        $breadcrumb = [];
        $path = '';

        foreach ($segments as $segment) {
            $path = $path ? "{$path}/{$segment}" : $segment;
            $breadcrumb[] = [
                'name' => $segment,
                'path' => $path,
            ];
        }

        return $breadcrumb;
    }

    public function new_folder(Request $request)
    {
        try {
            $parent_id = null;
            $file = new Filesystem;
            $real_path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $request->current_dir);
            $path = 'app/documents'.$real_path;
            $directory = 'app/documents'.$real_path.'\\'.$request->name;
            if (! $request->current_dir == '') {
                $record = Folders::query()->where('path', $path)->first();
                if ($file->isDirectory(storage_path($directory))) {
                    return response()->json('Folder Name Exit', 400, ['message' => 'success']);
                } else {
                    Folders::query()->create([
                        'name' => $request->name,
                        'path' => $directory,
                        'parent_id' => $record->id,
                    ]);
                    $file->makeDirectory(storage_path($directory), 755, true, true);

                    return response()->json([], 200, ['message' => 'success']);
                }
            } else {
                if ($file->isDirectory(storage_path($directory))) {
                    return response()->json([], 400, ['message' => 'success']);
                } else {
                    Folders::query()->create([
                        'name' => $request->name,
                        'path' => $directory,
                    ]);
                    $file->makeDirectory(storage_path($directory), 755, true, true);

                    return response()->json([], 200, ['message' => 'success']);
                }
            }

            return response()->json([], 200, ['message' => 'success']);
        } catch (Exception $e) {
            Log::debug($e);
            return response()->json($e, 500, ['message' => 'failed']);
        }
    }

    public function new_file(Request $request)
    {
        $request->validate([
            'document' => 'required|file|mimes:pdf,doc,docx|max:2048', // Example validation rules
        ]);
        try {
            $request->validate([
                'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);
            $file = $request->file('file');
            $path = 'documents'.$request->current_dir;
            $file_name = $file->getClientOriginalName();
            if ($request->hasFile('file')) {
                $request->file('file')->storeAs($path, $file_name);
            }
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    public function new_user(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'fname' => 'required',
        ]);
        try {
            $hash_password = Hash::make($request->password);
            $user_data = User::query()->create([
                'name' => $request->fname,
                'email' => $request->email,
                'password' => $hash_password,
                'status' => 1,
            ]);
            $user_data->assignRole($request->role);

            return response()->json([
                'status' => 200,
                'message' => 'Success user creation',
                'data' => $user_data,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => $this->err_name($e->errorInfo[1])], 500);
        }
    }

    public function users_pg()
    {
        try {
            $users = User::all()->map(function ($user) {
                $roles = DB::table('model_has_roles')
                    ->join('roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->where('model_has_roles.model_id', $user->id)
                    ->pluck('roles.name', 'roles.id')->toArray();

                $permissions = DB::table('role_has_permissions')
                    ->join('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
                    ->where('role_has_permissions.role_id', array_keys($roles))
                    ->pluck('permissions.name');

                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $roles,
                    'permissions' => $permissions,
                    'created_at' => $user->created_at,
                ];
            });
            $roles = DB::select('select * from roles');

            return view('users', compact('users', 'roles'));
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    public function roles_pg()
    {
        try {
            $roles = DB::select('select * from roles');

            return view('roles', compact('roles'));
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function permission_pg()
    {
        try {
            $perm = DB::select('select * from permissions');

            return view('permission', compact('perm'));
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function new_role(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            DB::insert('insert into roles (name, guard_name) values (?, ?)', [$request->name, 'web']);

            return response()->json([
                'status' => 200,
                'message' => 'Success user creation',
                'data']);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => $this->err_name($e->errorInfo[1])], 500);
        }
    }

    public function new_permission(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
            DB::insert('insert into permissions (name, guard_name) values (?, ?)', [$request->name, 'web']);

            return response()->json([
                'status' => 200,
                'message' => 'Success user creation',
                'data']);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => $this->err_name($e->errorInfo[1])], 500);
        }
    }

    private function err_name($exception)
    {
        $errorCode = $exception ?? null;

        return match ($errorCode) {
            1062 => 'Duplicate record found.',
            1048 => 'Required field is missing.',
            default => 'Something went wrong.',
        };
    }

    public function access_pg()
    {
        try {
            $base = 'documents';
            $roles = Role::with('permissions')->get();
            $permission = DB::select('select * from permissions');
            $users = DB::select('select * from users where status = ?', [1]);
            $matrix_role = [];

            foreach ($roles as $role) {
                $matrix_role[$role->id] = $role->permissions->pluck('id')->toArray();
            }

            $directories = collect(Storage::directories('documents'))->map(function ($path) use ($base) {
                return [
                    'name' => basename($path),
                    'path' => str_replace("{$base}/", '', $path),
                ];
            });

            return view('access', compact('roles', 'permission', 'matrix_role', 'users', 'directories'));
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function update_access(Request $request)
    {
        try {
            $request->validate([
                'role_id' => 'required|integer',
                'permission_id' => 'required|integer',
                'checked' => 'required',
            ]);
            $role = Role::findOrFail($request->role_id);
            $permission = Permission::findOrFail($request->permission_id);
            if ($request->checked === 'true') {
                $role->givePermissionTo($permission);

                return response()->json(['message' => 'Permission assigned']);
            } else {
                $role->revokePermissionTo($permission);

                return response()->json(['message' => 'Permission revoked']);
            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => $this->err_name($e->errorInfo[1])], 500);
        }
    }

    public function fdaccess_pg($id)
    {
        try {
            $user_id = $id;
            $folders = Folders::whereNull('parent_id')
                ->with('childrenRecursive')
                ->get();
            $assigned_folders = FolderUsers::where('user_id', $id)->pluck('folder_id')->toArray();

            return view('folder_access', compact('folders', 'user_id'));
        } catch (Exception $e) {
            Log::debug($e->getMessage());
        }
    }

    public function getFolders($id)
    {
        try {
            $assigned_folders = FolderUsers::where('user_id', $id)->pluck('folder_id')->toArray();

            return response()->json($assigned_folders, 200, []);
        } catch (Exception $e) {
            Log::debug($e->getMessage());

            return response()->json([], 400, []);
        }
    }

    public function create_folder_tb($path, $parentId = null)
    {
        try {
            $path = storage_path('app/documents');
            $folders = File::directories($path);
            foreach ($folders as $folderPath) {
                $folder = Folders::updateOrCreate(
                    ['path' => $folderPath],
                    [
                        'name' => basename($folderPath),
                        'parent_id' => $parentId,
                    ]
                );
            }
        } catch (Expetion $e) {
            Log::debug($e->getMessage());
        }
    }

    public function folderAccess(Request $request)
    {
        try {
            $folders_co = $request->selectedFolders != '[]' ? json_decode($request->selectedFolders, true) : [];
            $exitsingFolder = FolderUsers::where('user_id', $request->user_id)->pluck('folder_id')->toArray();
            $tobe_add = array_diff($folders_co, $exitsingFolder);
            $tobe_remove = array_diff($exitsingFolder, $folders_co);
            if (count($folders_co) == 0) {
                $user_has_fd = FolderUsers::where('user_id', $request->user_id)->get();
                $user_has_fd->isEmpty() ? exit : FolderUsers::where('user_id', $request->user_id)->delete();
            } elseif (! empty($tobe_remove)) {
                FolderUsers::where('user_id', $request->user_id)
                    ->whereIn('folder_id', $tobe_remove)
                    ->delete();
                foreach ($tobe_add as $fd_id) {
                    FolderUsers::create([
                        'folder_id' => $fd_id,
                        'user_id' => $request->user_id,
                    ]);
                }
            } else {
                foreach ($tobe_add as $fd_id) {
                    FolderUsers::create([
                        'folder_id' => $fd_id,
                        'user_id' => $request->user_id,
                    ]);
                }
            }

            return response()->json(['message' => 'completed'], 200, []);
        } catch (Exception $e) {
            Log::debug($e);
        }
    }

    private function get_user_folder($user_id,$dir=null)
    {
      if($dir===null)
      {
      $data = FolderUsers::where('user_id', $user_id)
            ->with(['folder_list' => fn ($q) => $q->whereNull('parent_id')])
            ->get()
            ->pluck('folder_list')
            ->filter();
      return $data;
      }
      else
      {
      $data = FolderUsers::where('user_id', $user_id)
            ->with(['folder_list' => function ($q) use ($dir)
            {
               $q->where('parent_id',$dir);
            }])
            ->get()
            ->pluck('folder_list')
            ->filter();
      return $data;
      }

    }
}
