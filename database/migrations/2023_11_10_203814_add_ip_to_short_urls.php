<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::table( 'short_urls', function ( Blueprint $table ) {
            $table->string( 'ip' )->after( 'long_url' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::table( 'short_urls', function ( Blueprint $table ) {
            $table->dropColumn( 'ip' );
        } );
    }
};
