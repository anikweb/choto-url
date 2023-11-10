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
                return redirect()->away( $shortUrl->long_url, 301 );
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
            'alias'    => 'nullable|regex:/^[a-zA-Z0-9- ]+$/u|string',
        ], [
            'alias.regex' => 'Please enter a valid alias, do not use any special character.',
        ] );

        $longURL       = rtrim( $request->long_url, '/' );
        $shortURLQuery = ShortUrl::query();

        if ( $request->alias == '' ) {
            // generate custom alias
            $existingShortUrl = ( clone $shortURLQuery )->where( 'long_url', $longURL )->first();

            if ( !empty( $existingShortUrl ) ) {
                $chotoUrl = url( '/' ) . '/' . $existingShortUrl->short_url;

                $existingShortUrl->short_url = $chotoUrl;

                return response()->json( success( 'Choto URL already exist', $existingShortUrl ) );
            }
            // generate random alias
            $shortURL = generateRandomAlias( $shortURLQuery );

        } else {
            $shortURL = Str::slug( $request->alias );

            $existingShortUrl = ( clone $shortURLQuery )->where( 'short_url', $shortURL )->whereNot( 'long_url', $longURL )->first();

            if ( !empty( $existingShortUrl ) ) {
                return response()->json( error( 'This alias has been taken, choose another one' ) );
            }

            $existingShortUrl = ( clone $shortURLQuery )->where( 'long_url', $longURL )->where( 'short_url', $shortURL )->first();

            if ( !empty( $existingShortUrl ) ) {
                $chotoUrl = url( '/' ) . '/' . $existingShortUrl->short_url;

                $existingShortUrl->short_url = $chotoUrl;

                return response()->json( success( 'Choto URL already exist with this alias', $existingShortUrl ) );
            }
        }

        $shortUrl = ShortUrl::create( [
            'long_url'  => $longURL,
            'short_url' => $shortURL,
        ] );

        $chotoUrl            = url( '/' ) . '/' . $shortUrl->short_url;
        $shortUrl->short_url = $chotoUrl;
        return response()->json( success( 'Choto URL generated', $shortUrl ) );

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

    /**
     * @param $shortURLQuery
     */

}
