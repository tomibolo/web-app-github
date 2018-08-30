<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $primaryKey = 'contact_id';

    protected $table = 'addresses';

    protected $fillable = ['address', 'number', 'state', 'city'];

    protected $hidden = ['contact_id', 'created_at', 'updated_at'];
    
    public $timestamps = false;
}