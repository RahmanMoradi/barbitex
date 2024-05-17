<?php


namespace App\Http\Controllers\Traits\General;


use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

trait Uploadable {
    public function uploadFile( $patch , $file = null ) {
        if ( $file === null ) {
            return null;
        };
        $years = Carbon::now()->year;
        return 'uploads/' . Storage::disk( 'public' )->put( "$patch/$years" , $file );
    }

    public function uploadFileBase64( $patch , $file ) {
        $base64_image = $file;

        if ( preg_match( '/^data:image\/(\w+);base64,/' , $base64_image ) ) {
            $data = substr( $base64_image , strpos( $base64_image , ',' ) + 1 );

            $data  = base64_decode( $data );
            $name  = str_random( 20 ) . '.png';
            $years = Carbon::now()->year;
            Storage::disk( 'public' )->put( "$patch/$years/$name" , $data );

            return "uploads/$patch/$years/$name";
        }
    }

    protected function deleteFile($filePath, $storage = 'public')
    {
        if (Storage::disk($storage)->exists($filePath))
            return Storage::disk($storage)->delete($filePath);
    }
}
