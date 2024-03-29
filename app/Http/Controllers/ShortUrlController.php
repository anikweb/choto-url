<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ShortUrl;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ShortUrlStoreRequest;

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
        // return
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( ShortUrlStoreRequest $request ) {

        // ip validation
        $ip    = $request->getClientIp( 'X-Real-IP' );
        $limit = intval( env( 'DAILY_LIMIT', 10 ) );

        if ( $this->isReachedDayLimit( $ip, $limit ) ) {
            return error( 'You have reached your daily limit' );
        }

        $longURL       = rtrim( $request->long_url, '/' );
        $shortURLQuery = ShortUrl::query();

        if ( $request->alias == '' ) {
            // generate custom alias
            $existingShortUrl = ( clone $shortURLQuery )->where( 'long_url', $longURL )->first();

            if ( !empty( $existingShortUrl ) ) {
                $chotoUrl                    = url( '/' ) . '/' . $existingShortUrl->short_url;
                $existingShortUrl->short_url = $chotoUrl;
                return success( 'Choto URL already exist', $existingShortUrl );
            }
            // generate random alias
            $shortURL = generateRandomAlias( $shortURLQuery );

        } else {
            $shortURL         = Str::slug( $request->alias );
            $existingShortUrl = ( clone $shortURLQuery )->where( 'short_url', $shortURL )->whereNot( 'long_url', $longURL )->first();

            if ( !empty( $existingShortUrl ) ) {
                return error( 'This alias has been taken, choose another one' );
            }

            $existingShortUrl = ( clone $shortURLQuery )->where( 'long_url', $longURL )->where( 'short_url', $shortURL )->first();

            if ( !empty( $existingShortUrl ) ) {
                $chotoUrl = url( '/' ) . '/' . $existingShortUrl->short_url;

                $existingShortUrl->short_url = $chotoUrl;

                return success( 'Choto URL already exist with this alias', $existingShortUrl );
            }
        }

        $shortUrl = ShortUrl::create( [
            'long_url'  => $longURL,
            'short_url' => $shortURL,
            'ip'        => $ip,
        ] );

        $chotoUrl            = url( '/' ) . '/' . $shortUrl->short_url;
        $shortUrl->short_url = $chotoUrl;
        return success( 'Choto URL generated', $shortUrl );

    }

    /**
     * @param $ip
     */
    private function isReachedDayLimit( string $ip, int $limit ): bool {
        $count = ShortUrl::where( 'ip', $ip )
            ->whereDate( 'created_at', Carbon::today() )
            ->count();

        if ( $count >= $limit ) {
            return true;
        }
        return false;
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
