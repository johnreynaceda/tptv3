<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEsmAndPreferredProgramToResultsTable extends Migration
{
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->string('preferred_program')->nullable()->after('full_name');
            $table->string('esm_raw_score')->nullable()->after('social_studies_standard_score');
            $table->string('esm_standard_score')->nullable()->after('esm_raw_score');
        });
    }

    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->dropColumn(['preferred_program', 'esm_raw_score', 'esm_standard_score']);
        });
    }
}
