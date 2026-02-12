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
            if (!Schema::hasColumn('stores', 'minimum_order'))
                $table->decimal('minimum_order', 10, 2)->default(0);
            if (!Schema::hasColumn('stores', 'comission'))
                $table->decimal('comission', 10, 2)->nullable();
            if (!Schema::hasColumn('stores', 'delivery_charge'))
                $table->decimal('delivery_charge', 10, 2)->default(0);
            if (!Schema::hasColumn('stores', 'schedule_order'))
                $table->boolean('schedule_order')->default(0);
            if (!Schema::hasColumn('stores', 'free_delivery'))
                $table->boolean('free_delivery')->default(0);
            if (!Schema::hasColumn('stores', 'delivery'))
                $table->boolean('delivery')->default(0);
            if (!Schema::hasColumn('stores', 'take_away'))
                $table->boolean('take_away')->default(0);
            if (!Schema::hasColumn('stores', 'item_section'))
                $table->boolean('item_section')->default(1);
            if (!Schema::hasColumn('stores', 'reviews_section'))
                $table->boolean('reviews_section')->default(1);
            if (!Schema::hasColumn('stores', 'active'))
                $table->boolean('active')->default(1);
            if (!Schema::hasColumn('stores', 'pos_system'))
                $table->boolean('pos_system')->default(0);
            if (!Schema::hasColumn('stores', 'self_delivery_system'))
                $table->boolean('self_delivery_system')->default(0);
            if (!Schema::hasColumn('stores', 'open'))
                $table->boolean('open')->default(1);
            if (!Schema::hasColumn('stores', 'off_day'))
                $table->string('off_day')->default(' ');
            if (!Schema::hasColumn('stores', 'gst'))
                $table->string('gst')->nullable();
            if (!Schema::hasColumn('stores', 'veg'))
                $table->boolean('veg')->default(1);
            if (!Schema::hasColumn('stores', 'non_veg'))
                $table->boolean('non_veg')->default(1);
            if (!Schema::hasColumn('stores', 'order_place_to_schedule_interval'))
                $table->integer('order_place_to_schedule_interval')->default(0);
            if (!Schema::hasColumn('stores', 'featured'))
                $table->boolean('featured')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn([
                'minimum_order',
                'comission',
                'delivery_charge',
                'schedule_order',
                'free_delivery',
                'delivery',
                'take_away',
                'item_section',
                'reviews_section',
                'active',
                'pos_system',
                'self_delivery_system',
                'open',
                'off_day',
                'gst',
                'veg',
                'non_veg',
                'order_place_to_schedule_interval',
                'featured'
            ]);
        });
    }
};
