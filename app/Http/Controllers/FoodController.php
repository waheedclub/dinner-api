<?php

namespace App\Http\Controllers;

use App\Models\Food;
use App\Models\Food_users;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->respond()
        ->data(['foods' => Food::withCount('users')->get()])
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $validated = $request->validate([
            'date' => 'required|date',
            'hotel_amount' => 'required|numeric',
            'other_amount' => 'required|numeric',
            'owner_id' => 'required|numeric',
             'users' => 'required|array'
        ]);
        unset($validated['users']);
        $validated['added_by'] = auth()->user()->id;
        $food = Food::create($validated);
        if($food) {
            $total = $request->hotel_amount + $request->other_amount;
            $per_head = round($total/count($request->users), 2);
            $food_user['food_id'] = $food->id;
            $food_user['amount'] = $per_head;

            foreach($request->users as $user_id) {
                $food_user['user_id'] = $user_id;
                Food_users::create($food_user);
            }
        }
        return $this->respond()
        ->message('Food added successfully')
        ->send();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function show(Food $food)
    {
        $data['current_food'] = $food->load('users', 'given_by_user', 'added_by_user');
        return $this->respond()
       ->data($data)
       ->send();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function edit(Food $food)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Food $food)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Food  $food
     * @return \Illuminate\Http\Response
     */
    public function destroy(Food $food)
    {
        $this->middleware('admin');
        $food->food_users()->delete();
        $food->delete();
        return $this->respond()
        ->message("Food item deleted successfully")
        ->send();
    }
}
