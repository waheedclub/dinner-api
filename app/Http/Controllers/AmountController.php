<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAmountRequest;
use App\Http\Requests\UpdateAmountRequest;
use App\Models\Amount;
use Illuminate\Http\Request;

class AmountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respond()
        ->data(['amounts' => Amount::with('sender', 'receiver')->get()])
        ->send();
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|numeric',
            'is_approved' => 'required:numeric'
        ]);
        $data['is_approved'] =  $request->is_approved;
        Amount::whereId($request->id)->update($data);

        return $this->respond()
        ->message('Status updated successfully')
        ->send();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAmountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'amount' => 'required|numeric',
            'sender_id' => 'required|numeric',
            'receiver_id' => 'required|numeric',
        ]);

        $user = Amount::create($validated);
        return $this->respond()
       ->message('Amount added successfully')
       ->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Amount  $amount
     * @return \Illuminate\Http\Response
     */
    public function show(Amount $amount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Amount  $amount
     * @return \Illuminate\Http\Response
     */
    public function edit(Amount $amount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAmountRequest  $request
     * @param  \App\Models\Amount  $amount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAmountRequest $request, Amount $amount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Amount  $amount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Amount $amount)
    {
        //
    }
}
