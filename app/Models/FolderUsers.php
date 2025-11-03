<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Folders;

class FolderUsers extends Model
{
    protected $table ='folders_users';

    protected $fillable = [
        'folder_id',
        'user_id'
    ];

    public function folder_list()
    {
        return $this->hasMany(Folders::class,'id','folder_id');
    }
}
