<?php
namespace App\Models;
/**
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="WEB CHALLENGE API DOCUMENTATION",
 *     version="1.0.0"
 *   )
 * )
 */
use Illuminate\Database\Eloquent\Model;
/** 
*    @SWG\Definition(
*        definition="Address",
*                       @SWG\Property(property="address", type="string", example="Kozey Flat"),
*                       @SWG\Property(property="state", type="string", example="Massachusetts"),
*                       @SWG\Property(property="number", type="int", example="40424"),
*                       @SWG\Property(property="city", type="string", example="Bryceshire"),
*   )
*/

class Address extends Model
{
    protected $primaryKey = 'contact_id';

    protected $table = 'addresses';

    protected $fillable = ['address', 'number', 'state', 'city'];

    protected $hidden = ['contact_id', 'created_at', 'updated_at'];
    
    public $timestamps = false;
}