<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Address;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $with = ['address'];

    protected $fillable = ['name', 'company', 'profile_image', 'email', 'birthdate', 'phone_number'];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function address()
    {
        return $this->hasOne(Address::class, 'contact_id');
    }

    public function scopeFilters($query,  $request)
    {
        if ($request->has('email')) $query = $query->whereEmail($request->get('email'));

        return $query;
    }

    public function syncAddress($data){

        $address = $this->address ?: new Address;

        $this->address()->save( $address->fill($data) );

    }

    public static function customCreate(array $data){

        $model = Contact::create($data);

        if(isset($data['address'])) $model->syncAddress($data['address']);

        return $model->fresh();

    }

}