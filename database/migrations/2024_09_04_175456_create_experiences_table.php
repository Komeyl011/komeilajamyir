<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            /*
             * @php
                    $custom = '02-17-2005';
                    $now = new DateTime();
                    $custom_date = DateTime::createFromFormat('m-d-Y', $custom);
                    $formatter = new IntlDateFormatter(
                        "fa_IR@calendar=persian",
                        IntlDateFormatter::FULL,
                        IntlDateFormatter::FULL,
                        'Asia/Tehran',
                        IntlDateFormatter::TRADITIONAL,
                        'yyyy-MM-dd'
                    );
                    dd($formatter->format($custom_date));
                @endphp

             */
            $table->id();
            $table->jsonb('job_title');
            $table->jsonb('company');
            $table->date('from');
            $table->date('to');
            $table->jsonb('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
