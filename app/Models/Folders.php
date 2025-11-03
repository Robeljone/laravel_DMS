<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Folders extends Model
{
    protected $table ='folders';

    protected $fillable = [
        'name',
        'path',
        'parent_id'
    ];

    public function childrenRecursive()
    {
    return $this->hasMany(Folders::class, 'parent_id')->with('childrenRecursive');
    }

    public function folder_user()
    {
        return $this->hasMany(FolderUsers::class, 'id','folder_id');
    }
}
