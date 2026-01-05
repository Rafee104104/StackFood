<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (!Schema::hasColumn('stores', 'logo'))
                $table->string('logo')->nullable();
            if (!Schema::hasColumn('stores', 'cover_photo'))
                $table->string('cover_photo')->nullable();
            if (!Schema::hasColumn('stores', 'latitude'))
                $table->string('latitude')->nullable();
            if (!Schema::hasColumn('stores', 'longitude'))
                $table->string('longitude')->nullable();
            if (!Schema::hasColumn('stores', 'vendor_id'))
                $table->bigInteger('vendor_id')->unsigned()->nullable();
            if (!Schema::hasColumn('stores', 'zone_id'))
                $table->bigInteger('zone_id')->unsigned()->nullable();
            if (!Schema::hasColumn('stores', 'module_id'))
                $table->bigInteger('module_id')->unsigned()->nullable();
            if (!Schema::hasColumn('stores', 'tax'))
                $table->decimal('tax', 8, 2)->default(0);
            if (!Schema::hasColumn('stores', 'delivery_time'))
                $table->string('delivery_time')->nullable();

            // Add foreign key constraints if tables exist, usually good practice but preventing errors if order is mixed
            // $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            // $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            // $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'logo',
                'cover_photo',
                'latitude',
                'longitude',
                'vendor_id',
                'zone_id',
                'module_id',
                'tax',
                'delivery_time'
            ]);
        });
    }
};
