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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return new ContactsResource(Contact::filters($request)->paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        return new ContactResource(Contact::customCreate($request->all()));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        if(isset($request->all()['address'])) $contact->syncAddress($request->all()['address']);

        $contact->fill($request->all())->save();
        
        return new ContactResource($contact->fresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        
        return response()->json(['data' => 'ok']);
    }

}
