<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create( 'short_urls', function ( Blueprint $table ) {
            $table->id();
            $table->longText( 'long_url' );
            // add short text with max key limit
            $table->longText( 'short_url' );
            $table->timestamps();
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists( 'short_urls' );
    }
};
