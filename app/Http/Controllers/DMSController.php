<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Filesystem\Filesystem;

class DMSController extends Controller
{

    public function login()
    {
        return view('login');
    }

    public function login_user(Request $request)
    {
        try{
         $user = User::query()->where('email','=',$request->email)->first()->get();
         if (Hash::check($request->password,$user[0]->password)) 
          {
          return redirect('dashboard');
          }
        }
        catch(Exception $e)
        {
            Log::debug($e);
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

        public function index()
    {
        return $this->loadDirectory();
    }

    /**
     * Display a specific directory and its content.
     */
    public function show($dir = null)
    {
        return $this->loadDirectory($dir);
    }

    /**
     * Reusable method for loading folder structure.
     */
    private function loadDirectory($dir = null)
    {
        $base = 'documents';
     
        $directory = $dir ? "{$base}/{$dir}" : $base;
        
        $directories = collect(Storage::directories($directory))->map(function ($path) use ($base) {
            return [
                'name' => basename($path),
                'path' => str_replace("{$base}/", '', $path),
            ];
        });
        $files = collect(Storage::files($directory))->map(function ($path) use ($base) {
            return [
                'name' => basename($path),
                'path' => str_replace("{$base}/", '', $path),
            ];
        });
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
        if (!$dir) return [];
    
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
        try
        {
          Log::debug($request);
          $file = new Filesystem();
          $directory = 'app/documents'.$request->current_dir.'/'.$request->name;
          if( $file->isDirectory(storage_path($directory)))
          {
          return response()->json([],400, ['message'=>'success']);
          }
          else
          {
           $file->makeDirectory(storage_path($directory), 755, true, true); 
            return response()->json([],200, ['message'=>'success']);
          }
        }catch(Exception $e)
        {
            Log::debug($e);
            return response()->json($e,500, ['message'=>'failed']);
        }
    }
   
    public function new_file(Request $request)
    {
        $request->validate([
                    'document' => 'required|file|mimes:pdf,doc,docx|max:2048', // Example validation rules
                ]);
        try{
            $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:2048',
        ]);
            $file = $request->file('file');
            $path = 'documents'.$request->current_dir;
            $file_name = $file->getClientOriginalName();
           if($request->hasFile('file'))
           {
            $request->file('file')->storeAs($path,$file_name);
           }
        }catch(Exception $e)
        {
            Log::debug($e);
        }
    }

    public function new_user(Request $request)
    {
      $request->validate([
        'email'=>'required',
        'password'=>'required',
        'fname'=>'required'
      ]);
      try{
        $hash_password = Hash::make($request->password);
        User::query()->create([
           'name'=>$request->fname,
           'email'=>$request->email,
           'password'=>$hash_password ,
           'status'=>1
         ]);
      }catch(Exception $e)
      {
         Log::debug($e);
      }
    }

    public function users_pg()
    {
      try{
       $users = User::query()->where('status','!=',3)->get();
       return view('users',compact('users'));
      }catch(Exception $e)
      {
         Log::debug($e);
      }
    }
}
