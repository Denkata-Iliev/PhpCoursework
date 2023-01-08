<?php

namespace App\Http\Controllers;

use App\Http\Requests\TakeRoomRequest;
use App\Models\Room;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RoomController extends Controller
{
    const NO_PERMISSION = "You don't have the necessary permission";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::all();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->validatePermissions();

        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomRequest $request)
    {
        Room::create($request->validated());

        return redirect()->route('rooms.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit(Room $room)
    {
        $this->validatePermissions();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        //
    }

    /**
     * Show the form for taking the specified room.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function take(Room $room)
    {
        abort_if(Gate::denies('access-rooms'), 403, self::NO_PERMISSION);

        if (!$room->is_free) {
            abort(403, "You can't take a room that's already been taken");
        }

        $user = Auth::user();
        if (count(Room::where('user_id', $user->id)->get()) >= 1) {
            abort(403, "You can't take more than one room at a time");
        }

        return view('rooms.take', compact('room'));
    }

    /**
     * Take the specified room.
     *
     * @param  \App\Http\Requests\TakeRoomRequest  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function takeRoom(TakeRoomRequest $request, Room $room)
    {
        $user = Auth::user();

        $room->update([
            'current_subject' => $request['current_subject'],
            'user_id' => $user->id,
            'is_free' => '0'
        ]);

        return redirect()->route('rooms.index');
    }

    /**
     * Dismiss the specified room.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function dismiss(Room $room)
    {
        abort_if(Gate::denies('access-rooms'), 403, self::NO_PERMISSION);

        $user = Auth::user();

        if ($room->user_id !== $user->id && !$user->can('access-rooms-crud')) {
            abort(403, self::NO_PERMISSION);
        }

        $room->update([
           'current_subject' => null,
           'user_id' => null,
           'is_free' => '1'
        ]);

        return redirect()->route('rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {
        $this->validatePermissions();
    }

    private function validatePermissions()
    {
        abort_if(Gate::denies('access-rooms-crud'), 403, self::NO_PERMISSION);
    }
}
