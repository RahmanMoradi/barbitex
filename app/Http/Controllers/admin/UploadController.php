<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UploadController extends Controller {
    public function upload( Request $request ) {
        return response()->json( [
            "uploaded" => 1 ,
            'fileName' => $request->upload ,
            'url'      => asset( $this->uploadFile( 'editor' , $request->upload ) ) ,
        ] );
    }
}
