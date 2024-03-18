<?php

namespace App\Http\Controllers\Frontend;

use App\Models\User;
use App\Models\Reservation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\MyAccount\UpdateRequest;
use Illuminate\Support\Facades\Lang;

class MyAccountController extends Controller
{
    public function index()
    {
        $user = User::find(auth()->id());

        return view('frontend.my-account.index', compact('user'));
    }

    public function update(UpdateRequest $request)
    {
        $user = User::find(auth()->id());

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'rut' => $request->get('rut'),
            'phone' => $request->get('phone')
        ]);

        if ($request->get('password')) {
            $user->update([
                'password' => bcrypt($request->get('password'))
            ]);
        }

        flasher(Lang::get('messages.frontend.saved_my_account'), 'success');
        return to_route('frontend.my_account.index');
    }

    public function reservations()
    {
        $reservations = Reservation::with('stadium', 'reservationItems')
            ->where('user_id', auth()->user()->id)
            ->paginate(10);

        return view('frontend.my-account.reservations', compact('reservations'));
    }
}
