<?php
use Illuminate\Support\Str;
/**
 * @param  $shortURLQuery
 * @return mixed
 */
function generateRandomAlias( $shortURLQuery ): string {
    do {
        $shortURL         = Str::slug( Str::random( 6 ) );
        $existingShortUrl = ( clone $shortURLQuery )->where( 'short_url', $shortURL )->first();
    } while ( !empty( $existingShortUrl ) );

    return $shortURL;
}

/**
 * @param $message
 */
function error( $message = "Something went wrong", $code = 500 ): array {
    $data = [
        'status'  => false,
        'code'    => $code,
        'message' => $message,
        'data'    => [],
    ];

    return $data;
}

/**
 * @param  array       $data
 * @param  $message
 * @return mixed
 */
function success( $message = "Success", $data = [], ): array {
    $data = [
        'status'  => true,
        'code'    => 200,
        'message' => $message,
        'data'    => $data,
    ];

    return $data;
}
