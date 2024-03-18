<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;
use App\Models\ReservationItem;
use App\Models\StadiumPrice;
use Illuminate\Support\Facades\Lang;

class ReservationCalendar
{
    protected $date;
    protected $stadiumId;

    public function __construct($date = null, $stadiumId = null)
    {
        $this->date = $date;
        $this->stadiumId = $stadiumId;
    }

    public function renderTable()
    {
        $headerDays = $this->getHeaderDays($this->date);
        $dates = $headerDays['headerDays'];
        $bodyHours = $this->getBodyHoursAndPrice($dates, $this->stadiumId);

        return '
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>
                            HORA
                        </th>
                        ' . $headerDays['html'] . '
                    </tr>
                    <tr>
                        ' . $bodyHours . '
                    </tr>
                </tbody>
            </table>
        ';
    }

    private function getHeaderDays()
    {
        $headerDays = [];
        $c = 0;
        while ($c < 7) {
            $headerDays[] = [
                'date' => $this->date->format('d-m-Y'),
                'name' => Lang::get('messages.reservations.header_days.' . Carbon::parse($this->date)->format('l'))
            ];

            $this->date->addDay();
            $c++;
        }

        $html = '';

        foreach ($headerDays as $header) {
            $html .= '<th><div>' . $header['name'] . '</div><span>' . $header['date'] . '</span></th>';
        }

        return [
            'headerDays' => $headerDays,
            'html' => $html
        ];
    }

    private function checkIfDayIsReserved($date, $hour)
    {
        $response = false;

        $reservationItems = ReservationItem::with('reservation')
            ->whereHas('reservation', function ($query) {
                $query->where('stadium_id', $this->stadiumId);
            })
            ->where('date', $date)
            ->where('hour', $hour)
            ->get();

        if ($reservationItems->count()) {
            foreach ($reservationItems as $reservationItem) {
                if ($reservationItem->reservation->state == 'Pagada' || $reservationItem->reservation->state == 'Pendiente') {
                    $response = true;
                    break;
                }
            }
        }

        return $response;
    }

    public function calculatePrice($hour, $date)
    {
        $text = '0';
        $price = 0;

        if ($date->isWeekend()) {
            $stadiumPrice = StadiumPrice::where('stadium_id', $this->stadiumId)
                ->where('hour', $hour)
                ->where('is_weekend', true)
                ->first();

            if ($stadiumPrice) {
                $text = '$' . chileanPeso($stadiumPrice->price);
                $price = $stadiumPrice->price;
            }
        } else {
            $stadiumPrice = StadiumPrice::where('stadium_id', $this->stadiumId)
                ->where('hour', $hour)
                ->where('is_weekend', false)
                ->first();

            if ($stadiumPrice) {
                $text = '$' . chileanPeso($stadiumPrice->price);
                $price = $stadiumPrice->price;
            }
        }

        return [
            'text' => $text,
            'price' => $price
        ];
    }

    private function getBodyHoursAndPrice($dates)
    {
        $hours = config('reusable.reservation_hours');

        $html = '';

        foreach ($hours as $hour) {
            $html .= '
                <tr>
                    <td>
                        ' . $hour . '
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[0]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[0]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[0]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[0]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[0]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[0]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[0]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[0]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[0]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[1]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[1]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[1]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[1]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[1]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[1]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[1]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[1]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[1]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[2]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[2]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[2]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[2]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[2]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[2]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[2]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[2]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[2]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[3]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[3]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[3]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[3]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[3]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[3]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[3]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[3]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[3]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[4]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[4]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[4]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[4]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[4]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[4]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[4]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[4]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[4]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[5]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[5]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[5]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[5]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[5]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[5]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[5]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[5]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[5]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                    <td>
                        <div class="form-check">
                            ' . ($this->checkIfDayIsReserved(Carbon::createFromFormat('d-m-Y', $dates[6]['date'])->format('Y-m-d'), $hour) ?
                '<input name="res[]" disabled type="checkbox" class="form-check-input" style="margin-top: 7px; margin-right: 5px;"><strong style="background-color: #FADBD6;"><label class="form-check-label">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[6]['date']))['text'] . '</label></strong>' :
                '<input name="res[]" value="' . $hour . '_' . $dates[6]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[6]['date']))['price'] . '" type="checkbox" class="form-check-input" id="' . $hour . '_' . $dates[6]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[6]['date']))['price'] . '" style="margin-top: 7px; margin-right: 5px;"><strong><label class="form-check-label" for="' . $hour . '_' . $dates[6]['date'] . '_' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[6]['date']))['price'] . '">' . $this->calculatePrice($hour, Carbon::createFromFormat('d-m-Y', $dates[6]['date']))['text'] . '</label></strong>') . '
                        </div>
                    </td>
                </tr>
            ';
        }

        return $html;
    }

    public function renderReservationsByDay()
    {
        $hours = config('reusable.reservation_hours');
        $html = '
            <table class="table table-bordered table-sm" id="table">
                <thead>
                    <tr class="d-flex">
                        <th class="col-2">HORA</th>
                        <th class="col-5">CLIENTE</th>
                        <th class="col-3">ESTADO</th>
                        <th class="col-2"></th>
                    </tr>
                </thead>

                <tbody>
        ';

        foreach ($hours as $hour) {
            $exists = $this->checkIfExistsReservationItem($hour);
            $state = '<h5><span class="badge badge-success">DISPONIBLE</span></h5>';

            if ($exists) {
                if ($exists['reservation']['state'] == 'Pagada') {
                    if ($exists['reservation']['user']['partner']) {
                        $state = '<h5><span class="badge badge-primary">RESERVA SOCIO (PAGADA)</span></h5>';
                    } else {
                        if ($exists['reservation']['type'] == 'Normal') {
                            $state = '<h5><span class="badge badge-danger">PAGADA</span></h5>';
                        } else if ($exists['reservation']['type'] == 'Fija') {
                            $state = '<h5><span class="badge badge-info">RESERVA FIJA (PAGADA)</span></h5>';
                        }
                    }
                } elseif ($exists['reservation']['state'] == 'Pendiente') {
                    if ($exists['reservation']['user']['partner']) {
                        $state = '<h5><span class="badge badge-primary">RESERVA SOCIO (PAGO PENDIENTE)</span></h5>';
                    } else {
                        if ($exists['reservation']['type'] == 'Normal') {
                            $state = '<h5><span class="badge badge-warning">PAGO PENDIENTE</span></h5>';
                        } else if ($exists['reservation']['type'] == 'Fija') {
                            $state = '<h5><span class="badge badge-info">RESERVA FIJA (PAGO PENDIENTE)</span></h5>';
                        }
                    }
                }

                $html .= '
                    <tr class="d-flex">
                        <td class="col-2">' . $hour . '</td>
                        <td class="col-5">' . $exists['user']['name'] . '</td>
                        <td class="col-3">' . $state . '</td>
                        <td class="col-2"><button type="button" class="btn btn-block btn-outline-primary btn-detail" data-id="' . $exists['reservation']['id'] . '"><i class="fa fa-book"></i> Detalle</button></td>
                    </tr>
                ';
            } else {
                $html .= '
                    <tr class="d-flex">
                        <td class="col-2">' . $hour . '</td>
                        <td class="col-5">-</td>
                        <td class="col-3">' . $state . '</td>
                        <td class="col-2"><button disabled class="btn btn-block btn-outline-primary"><i class="fa fa-book"></i> Detalle</button></td>
                    </tr>
                ';
            }
        }

        $html .= '
                </tbody>
            </table>
        ';

        return $html;
    }

    private function checkIfExistsReservationItem($hour)
    {
        $response = null;

        $reservationItems = ReservationItem::with('reservation', 'reservation.user')
            ->whereHas('reservation', function ($query) {
                $query->where('stadium_id', $this->stadiumId);
            })
            ->where('date', $this->date)
            ->where('hour', $hour)
            ->get();

        if ($reservationItems->count()) {
            foreach ($reservationItems as $reservationItem) {
                if ($reservationItem->reservation->state == 'Pagada' || $reservationItem->reservation->state == 'Pendiente') {
                    $response = [
                        'reservationItem' => $reservationItem,
                        'reservation' => $reservationItem->reservation,
                        'user' => $reservationItem->reservation->user
                    ];

                    break;
                }
            }
        }

        return $response;
    }

    public function renderHtmlReservationsByDayPdf()
    {
        $hours = config('reusable.reservation_hours');
        $html = '';

        foreach ($hours as $hour) {
            $reservationItem = ReservationItem::with('reservation', 'reservation.user')
                ->whereHas('reservation', function ($query) {
                    $query->where('reservations.stadium_id', $this->stadiumId);
                })
                ->where('reservation_items.date', $this->date)
                ->where('reservation_items.hour', $hour)
                ->first();

            $text = ($reservationItem) ? $reservationItem->reservation->user->name : '-';
            $price = ($reservationItem) ? '$' . chileanPeso($reservationItem->reservation->total) : '-';

            $html .= '
                <tr>
                    <td class="table-border">' . $hour . '</td>
                    <td class="table-border">' . $text . '</td>
                    <td class="table-border">' . $price . '</td>
                    <td class="table-border"></td>
                    <td class="table-border"></td>
                    <td class="table-border"></td>
                    <td class="table-border"></td>
                    <td class="table-border"></td>
                </tr>
            ';
        }

        return $html;
    }
}
