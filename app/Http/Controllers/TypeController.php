<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Unit;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'type' => Type::all(),
            'unit' => Unit::all(),
        ];

        return response($data, 201);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formfields = $request->validate([
            'name' => 'required|string',
        ]);

        $id = Type::create($formfields)->id;

        $params = $request['units'];
        $tags = explode(',', $params);
        $units = array();
        foreach ($tags as $item) {
            $units = array();
            if ($item != "" || $item != null) {
                $units = [
                    'type_id' => $id,
                    'unit' => $item,
                ];
                Unit::create($units);
            }
        }
        if ($units) {
            return response(['message' => 'Success!'], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function show(Type $type)
    {
        return Unit::where('type_id', $type['id'])->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Type $type)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Type  $type
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        $type->delete();
        Unit::where('type_id', $type['id'])->delete();
    }
}
