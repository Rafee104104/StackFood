<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class NormalizeDeliveryTimeInStoresTable extends Migration
{
    public function up()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->integer('delivery_time_min')->nullable()->after('delivery_time');
            $table->integer('delivery_time_max')->nullable()->after('delivery_time_min');
            $table->string('delivery_time_unit', 10)->nullable()->after('delivery_time_max');
        });

        // migrate old data
        $stores = DB::table('stores')->get();

        foreach ($stores as $store) {
            $min = 10;
            $max = 20;
            $unit = 'min';

            if (!empty($store->delivery_time) && str_contains($store->delivery_time, '-')) {
                $parts = explode('-', $store->delivery_time);
                $min = (int) trim($parts[0]);

                if (isset($parts[1])) {
                    $right = explode(' ', trim($parts[1]));
                    $max = (int) ($right[0] ?? 20);
                    $unit = $right[1] ?? 'min';
                }
            }

            DB::table('stores')
                ->where('id', $store->id)
                ->update([
                    'delivery_time_min' => $min,
                    'delivery_time_max' => $max,
                    'delivery_time_unit' => $unit,
                ]);
        }
    }

    public function down()
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'delivery_time_min',
                'delivery_time_max',
                'delivery_time_unit',
            ]);
        });
    }
}
