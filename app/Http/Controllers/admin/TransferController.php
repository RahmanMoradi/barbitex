<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Transfer;
use Illuminate\Http\Request;

class TransferController extends Controller {
    public function index() {
        $transfers = Transfer::all();

        return view( 'admin.transfer.index' , compact( 'transfers' ) );
    }

    public function show( $transfer ) {
        $transfer = Transfer::findOrFail( $transfer );

        return view( 'admin.transfer.show' , compact( 'transfer' ) );
    }
}
