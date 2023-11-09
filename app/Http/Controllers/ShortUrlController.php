<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShortUrlController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Request $request ) {

        $input = $request->except( '_token' );
        if ( $request->alias == '' ) {
            // generate custom alias
            $input['short_url'] = Str::random( 5 );
        } else {
            $input['short_url'] = $request->alias;
        }

        $shortUrl = ShortUrl::create( $input );
        return response()->json( $shortUrl );

    }

    /**
     * Display the specified resource.
     */
    public function show( ShortUrl $shortUrl ) {
        //~
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( ShortUrl $shortUrl ) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request, ShortUrl $shortUrl ) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( ShortUrl $shortUrl ) {
        //
    }
}
