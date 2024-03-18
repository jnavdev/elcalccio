<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Stadium;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use App\Models\StadiumPrice;

class StadiumPriceController extends Controller
{
    public function create($id)
    {
        $stadium = Stadium::with('stadiumPrices')->find($id);
        $hours = [
            '09:00-10:00',
            '10:00-11:00',
            '11:00-12:00',
            '12:00-13:00',
            '13:00-14:00',
            '14:00-15:00',
            '15:00-16:00',
            '16:00-17:00',
            '17:00-18:00',
            '18:00-19:00',
            '19:00-20:00',
            '20:00-21:00',
            '21:00-22:00',
            '22:00-23:00',
            '23:00-00:00',
        ];

        return view('backend.sections.stadiums.prices', compact('stadium', 'hours'));
    }

    public function store(Request $request, $id)
    {
        $stadium = Stadium::with('stadiumPrices')->find($id);
        $hoursWeekendNo = $request->get('hoursWeekendNo');
        $hoursWeekendYes = $request->get('hoursWeekendYes');

        if ($stadium->stadiumPrices->count()) {
            foreach ($hoursWeekendNo as $hour => $price) {
                $stadiumPrice = StadiumPrice::where('stadium_id', $id)
                    ->where('hour', $hour)
                    ->where('is_weekend', false)
                    ->first();

                $stadiumPrice->update([
                    'hour' => $hour,
                    'price' => str_replace('.', '', $price),
                    'is_weekend' => false
                ]);
            }

            foreach ($hoursWeekendYes as $hour => $price) {
                $stadiumPrice = StadiumPrice::where('stadium_id', $id)
                    ->where('hour', $hour)
                    ->where('is_weekend', true)
                    ->first();

                $stadiumPrice->update([
                    'hour' => $hour,
                    'price' => str_replace('.', '', $price),
                    'is_weekend' => true
                ]);
            }
        } else {
            foreach ($hoursWeekendNo as $hour => $price) {
                $stadium->stadiumPrices()->save(new StadiumPrice([
                    'hour' => $hour,
                    'price' => str_replace('.', '', $price),
                    'is_weekend' => false,
                ]));
            }

            foreach ($hoursWeekendYes as $hour => $price) {
                $stadium->stadiumPrices()->save(new StadiumPrice([
                    'hour' => $hour,
                    'price' => str_replace('.', '', $price),
                    'is_weekend' => true,
                ]));
            }
        }

        flasher(Lang::get('messages.crud.created'), 'success');
        return to_route('stadiums.index');
    }
}
