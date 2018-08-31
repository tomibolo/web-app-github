<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \App\Models\Address;

/** 
*    @SWG\Definition(
*        definition="Contact",
*                       @SWG\Property(property="id", type="integer", example="1"),
*                       @SWG\Property(property="name", type="string", example="Tomas"),
*                       @SWG\Property(property="company", type="string", example="X-Company"),
*                       @SWG\Property(property="profile_image", type="string", example="http://www.google.com"),
*                       @SWG\Property(property="email", type="string", example="stehr.jessika@yundt.com"),
*                       @SWG\Property(property="birthdate", type="string", example="2013-04-05"),
*                       @SWG\Property(property="phone_number_work", type="string", example="+5411589063561"),
*                       @SWG\Property(property="phone_number_personal", type="string", example="+5411589063561"),
*                       @SWG\Property(property="address", type="object", ref="#/definitions/Address")
*   )
*/
/**
* @SWG\Response(
*      response="200Contact",
*      description="the basic response",
*       @SWG\Schema(
*             type="object",
*             properties={
*                 @SWG\Property(property="data", type="object", ref="#/definitions/Contact"
*                   ),
*             }
*       )  
* )
*
*/
class Contact extends Model
{
    protected $table = 'contacts';

    protected $with = ['address'];

    protected $fillable = ['name', 'company', 'profile_image', 'email', 'birthdate', 'phone_number_work', 'phone_number_personal'];

    protected $hidden = ['created_at', 'updated_at'];
    
    public function address()
    {
        return $this->hasOne(Address::class, 'contact_id');
    }

    public function scopeFilters($query,  $request)
    {
        if ($request->has('email')) $query = $query->whereEmail($request->get('email'));
        if ($request->has('phone_number'))
        {
            $query = $query->where(function($q) use ($request)
                {
                    $q->orWhere('phone_number_work', 'like', '%'.$request->get('phone_number').'%')
                    ->orWhere('phone_number_personal', 'like', '%'.$request->get('phone_number').'%');
                }
            );

        } 

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