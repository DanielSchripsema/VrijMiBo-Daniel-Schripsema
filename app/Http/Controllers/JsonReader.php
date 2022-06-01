<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class JsonReader extends Controller
{
    public function index()
    {
        $value = Config::get('app.timezone');
        Config::set('app.timezone', $value);

        $orders = json_decode(file_get_contents(storage_path() . "/orders.json"), true);
        $tickets = json_decode(file_get_contents(storage_path() . "/tickets.json"), true);
        $question2 = $this->getHighestPayed($orders);

        $data = [
            'Question1'  => count($orders),
            'Question2First'  => $question2['orderer']['data']['first_name'] ,
            'Question2Last'  => $question2['orderer']['data']['last_name'],
            'Question3'  => $this->CalculateMTotalVIP($orders, $tickets),
            'Question4'  => $this->GetPaidBarcodes($orders),
            'orders'   => $orders,
            'tickets'   => $tickets
        ];

        return view('OrderView', $data);
    }

    private function CalculateMTotalVIP(mixed $orders, mixed $tickets)
    {
        $Mynouk = array_where($orders, function($key)
        {
            return $key['orderer']['data']['first_name'] ==  'Mynouk' && $key['orderer']['data']['last_name'] ==  'van de Ven';
        });
        $VIPPrice = array_where($tickets, function($key)
        {
            return $key['name'] ==  'VIP' ;
        });
        $PriceVIP = (float)$VIPPrice[1]['price'];

        $totalVIPMynoak = array_where($Mynouk[0]['purchases'], function($key) {
            return $key['ticket']['name'] == 'VIP';
        });
        return count($totalVIPMynoak) * $PriceVIP;
    }

    private function GetPaidBarcodes(mixed $orders)
    {
        //14:00:00 2022-05-30
        $AfterDate = Carbon::create(2022, 05, 30, 14, 00, 00, "Europe/Amsterdam");
        //14:05:00 2022-05-30
        $BeforeDate = Carbon::create(2022, 05, 30, 14, 05, 00, "Europe/Amsterdam");

        //date between
        $payedBetween = array_where($orders, function($key) use ($AfterDate, $BeforeDate) {
            $date = Carbon::parse($key['payments'][0]['created_at']);
            return $date->gte($AfterDate) && $date->lte($BeforeDate);
        });

        //regular tickets
        $total = array();
        foreach ($payedBetween as $order){
            $RegularTickets = array_where($order['purchases'], function($key)
            {
                return $key['ticket']['name'] == 'Regular';
            });
            $total = $total + $RegularTickets;
        }
        //extract barcodes
        $barcodes = array();
        foreach ($total as $order){
            array_push($barcodes, $order['barcode']);
        }
        return $barcodes;
    }

    private function getHighestPayed(mixed $orders)
    {
        $collection = collect($orders);
        return $collection->max();
    }

}
