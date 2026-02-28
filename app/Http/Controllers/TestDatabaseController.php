<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestDatabaseController extends Controller
{
    public function test()
    {
        $test = DB::connection('mysql2')->table('customers')->where('customer_id', '0000')->first()?->customer_name;

        dd($test);

    }
}
