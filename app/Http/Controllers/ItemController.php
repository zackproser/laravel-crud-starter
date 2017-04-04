<?php

namespace App\Http\Controllers;

use
    \App\Item,
    Illuminate\Http\Request,
    Illuminate\Validation\Rule,
    Illuminate\Support\Facades\Log
;

class ItemController extends Controller
{
    /**
     * Returns item validation rules
     *
     * @return Array Associative array describing item validation rules
     */
    private function getValidationRules()
    {
        return [
            'name' => 'bail|required|max:191', //Don't process further if item name is missing
            'image_url' => 'url', //The image_url must be a valid url
            'type' => [
                'required', //We need to know the item's type
                Rule::in(['type1', 'type2', 'type3']) //But only these are valid
            ]
        ];
    }

    /**
     * GET /items
     *
     * Returns all items
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('items API: GET items/');

        //Query all items from the database;
        $items = \App\Item::all();

        return response()->json($items);
    }

    /**
     * POST /items
     *
     * Create and save a new item
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('items API: POST items/');

        //Ensure POSTed data is valid for creating a item record
        //If a validation rule is not satisifed, execution stops here,
        //and a 422 response containing validation errors is returned
        $this->validate($request, $this->getValidationRules());

        //The request passed validation. We can populate a new item record and save it to the database;
        $item = new Item;

        $item->name = $request->name;
        $item->image_url = $request->image_url;
        $item->type = $request->type;

        //Commit item to database
        $item->save();
    }

    /**
     * PUT items/{id}
     *
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        Log::info(sprintf('items API: PUT items/%s', $item->id));

        //Ensure PUT data is valid for updating the item record
        //If a validation rule is not satisifed, execution stops here,
        //and a 422 response containing validation errors is returned
        $this->validate($request, $this->getValidationRules());

        $editStatus = $item->update($request->all());

        return response()->json([ 'success' => $editStatus ], $editStatus ? 200 : 500);
    }

    /**
     * DELETE items/{id}
     *
     * Remove the specified item from the database.
     *
     * @param  \App\item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        Log::info(sprintf('items API: DELETE items/%s', $item->id));

        $deleteStatus = \App\Item::find($item)->delete();

        return response()->json([ 'success' =>  $deleteStatus ], $deleteStatus ? 200 : 500);
    }
}
