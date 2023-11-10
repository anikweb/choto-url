<?php

namespace App\Http\Controllers;

use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ShortUrlController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index( $slug = '' ) {

        if ( $slug != '' ) {
            $shortUrl = ShortUrl::where( 'short_url', $slug )->first();
            if ( !empty( $shortUrl ) ) {
                return redirect( $shortUrl->long_url );

            }
            return abort( 404 );
        } else {
            return view( 'welcome' );
        }
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

        //  validate input and return a error message by json according to the input

        $request->validate( [
            'long_url' => 'required|url',
            'alias'    => 'nullable|unique:short_urls,short_url',
        ] );

        $longURL = rtrim( $request->long_url, '/' );

        if ( $request->alias == '' ) {
            // generate custom alias
            $existingShortUrl = ShortUrl::where( 'long_url', $longURL )->first();
            if ( !empty( $existingShortUrl ) ) {
                $shortURL = url( '/' ) . '/' . $existingShortUrl->short_url;
                return response()->json( $shortURL );
            }
            $shortURL = Str::random( 5 );
        } else {
            $shortURL         = $request->alias;
            $existingShortUrl = ShortUrl::where( 'long_url', $longURL )->where( 'short_url', $shortURL )->first();
        }

        // check long url is exists or not

        if ( !empty( $existingShortUrl ) ) {
            return response()->json( $existingShortUrl );
        }

        $shortUrl = ShortUrl::create( [
            'long_url'  => $longURL,
            'short_url' => $shortURL,
        ] );
        $chotoUrl = url( '/' ) . '/' . $shortUrl->short_url;
        return response()->json( $chotoUrl );

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
