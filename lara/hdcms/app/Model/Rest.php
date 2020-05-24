<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Rest extends Model
{
    //
    protected $table = 'rest';
    //protected $primaryKey = 'id';
    //protected $dateFormat = 'U';
    protected $fillable = ['name','intro','ip_address','show_what'];
    //protected $guarded = ['id'];

}
