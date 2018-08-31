<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ContactsResource;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
    * @SWG\Get(
    *   path="/api/contacts",
    *   tags={"Contacts"},
    *   description="Contacts endpoints",
    *   summary="Get Contacts",
    *   @SWG\Parameter( name="page", in="query", description="Set current page", required=false, type="integer",
    *         @SWG\Schema( type="object",
    *             properties={
    *                 @SWG\Property(property="page", type="integer", example="1"),
    *             }
    *         )
    *   ),     
    *   @SWG\Parameter( name="email", in="query", description="Set email", required=false, type="string",
    *         @SWG\Schema( type="object",
    *             properties={
    *                 @SWG\Property(property="email", type="string", example="stehr.jessika@yundt.com"),
    *             }
    *         )
    *   ),     
    *   @SWG\Parameter( name="phone_number", in="query", description="Set ´phone_number", required=false, type="string",
    *         @SWG\Schema( type="object",
    *             properties={
    *                 @SWG\Property(property="phone_number", type="string", example="+541158906356")
    *             }
    *         )
    *   ),     
    *   @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object", properties={   
    *       @SWG\Property(property="links", type="object",  properties={
    *           @SWG\Property(property="first", type="string", example="http://localhost:8000/api/contacts?page=1"),
    *           @SWG\Property(property="last", type="string", example="http://localhost:8000/api/contacts?page=1"),
    *           @SWG\Property(property="prev", type="string", example="null"),
    *           @SWG\Property(property="next", type="string", example="null")
    *       }),   
    *       @SWG\Property(property="meta", type="object",  properties={
    *           @SWG\Property(property="current_page", type="integer", example="1"),
    *           @SWG\Property(property="from", type="integer", example="1"),
    *           @SWG\Property(property="last_page", type="integer", example="1"),
    *           @SWG\Property(property="path", type="string", example="http://localhost:8000/api/contacts"),
    *           @SWG\Property(property="per_page", type="integer", example="15"),
    *           @SWG\Property(property="to", type="integer", example="4"),
    *           @SWG\Property(property="total", type="integer", example="4")
    *       }),   
    *       @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/Contact")),   
    *   })),
    *   @SWG\Response(response=500, description="internal server error")
    * )
    */
    public function index(Request $request)
    {
        return new ContactsResource(Contact::filters($request)->paginate());
    }

    /**
    * @SWG\Post(
    *   path="/api/contacts ",
    *   tags={"Contacts"},
    *   description="Contacts endpoints",
    *   summary="Create new contact",
    *   @SWG\Parameter(
    *     name="body",
    *     in="body",
    *     description="Create new contact",
    *     required=true,
    *     type="string",
    *         @SWG\Schema(
    *             type="object",
    *             properties={
    *                 @SWG\Property(property="data", type="object", properties={
    *                       @SWG\Property(property="name", type="string", example="Tomas"),
    *                       @SWG\Property(property="company", type="string", example="X-Company"),
    *                       @SWG\Property(property="profile_image", type="string", example="http://www.google.com"),
    *                       @SWG\Property(property="email", type="string", example="stehr.jessika@yundt.com"),
    *                       @SWG\Property(property="birthdate", type="string", example="2013-04-05"),
    *                       @SWG\Property(property="phone_number_work", type="string", example="+5411589063561"),
    *                       @SWG\Property(property="phone_number_personal", type="string", example="+5411589063561"),
    *                       @SWG\Property(property="address", type="object", ref="#/definitions/Address")
    *                 })
    *             }
    *         )
    *   ), 
    *   @SWG\Response(response=200, description="successful operation", @SWG\Schema(type="object", properties={   
    *       @SWG\Property(property="data", type="array", @SWG\Items(ref="#/definitions/Contact"))  
    *   })),
    *   @SWG\Response(response=500, description="internal server error")
    * )
    */
    public function store(ContactRequest $request)
    {
        return new ContactResource(Contact::customCreate($request->all()));
    }

    /**
    * @SWG\Get(
    *   path="/api/contacts/{contact_id}",
    *   tags={"Contacts"},
    *   description="Contacts endpoints",
    *   summary="Get Contact",
    *   @SWG\Parameter(
    *     name="contact_id",
    *     in="path",
    *     description="Get Contact",
    *     required=true,
    *     type="integer",
    *         @SWG\Schema(
    *             type="object",
    *             properties={
    *                 @SWG\Property(property="contact_id", type="integer", example="1"),
    *             }
    *         )
    *   ),  
    *   @SWG\Response(response=200, description="successful operation",ref="$/responses/200Contact"),
    *   @SWG\Response(response=500, description="internal server error")
    * )
    */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
    * @SWG\Put(
    *   path="/api/contacts/{contact_id}",
    *   tags={"Contacts"},
    *   description="Contacts endpoints",
    *   summary="Update Contact",
    *   @SWG\Parameter(
    *     name="contact_id",
    *     in="path",
    *     description="Update contact",
    *     required=true,
    *     type="integer",
    *         @SWG\Schema(
    *             type="object",
    *             properties={
    *                 @SWG\Property(property="contact", type="integer", example="1"),
    *             }
    *         )
    *   ),   
    *   @SWG\Parameter(
    *     name="body",
    *     in="body",
    *     description="Update contact",
    *     required=true,
    *     type="string",
    *         @SWG\Schema(
    *             type="object",
    *             properties={
    *                       @SWG\Property(property="name", type="string", example="Tomas"),
    *                       @SWG\Property(property="company", type="string", example="X-Company"),
    *                       @SWG\Property(property="profile_image", type="string", example="http://www.google.com"),
    *                       @SWG\Property(property="email", type="string", example="stehr.jessika@yundt.com"),
    *                       @SWG\Property(property="birthdate", type="string", example="2013-04-05"),
    *                       @SWG\Property(property="phone_number_work", type="string", example="+5411589063561"),
    *                       @SWG\Property(property="phone_number_personal", type="string", example="+5411589063561"),
    *                       @SWG\Property(property="address", type="object", ref="#/definitions/Address")
    *             }
    *         )
    *   ),
    *   @SWG\Response(response=200, description="successful operation",ref="$/responses/200Contact"),
    *   @SWG\Response(response=500, description="internal server error")
    * )
    */
    public function update(ContactRequest $request, Contact $contact)
    {
        if(isset($request->all()['address'])) $contact->syncAddress($request->all()['address']);

        $contact->fill($request->all())->save();
        
        return new ContactResource($contact->fresh());
    }

    /**
    * @SWG\Delete(
    *   path="/api/concats/{contact_id}",
    *   tags={"Contacts"},
    *   description="Contacts endpoints",
    *   summary="Delete Contact",   
    *   @SWG\Parameter(
    *     name="contact_id",
    *     in="path",
    *     description="Delete contact",
    *     required=true,
    *     type="integer",
    *         @SWG\Schema(
    *             type="object",
    *             properties={
    *                 @SWG\Property(property="contact_id", type="integer", example="1"),
    *             }
    *         )
    *   ),
    *   @SWG\Response(
    *       response=200, description="successful operation",
    *       @SWG\Schema(
    *             type="object",
    *             properties={
    *                 @SWG\Property(property="data", type="string", example="true"),
    *             }
    *       )           
    *   ),
    *   @SWG\Response(response=500, description="internal server error")
    * )
    */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return response()->json(['data' => 'ok']);
    }

}
