<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('landing_pages', function (Blueprint $table) {
            $table->id();
            $table->string("name", 200)->nullable();
            $table->string("slug", 100)->nullable();
            $table->string("title", 100)->nullable();
            $table->string("sub_title", 200)->nullable();
            $table->string("first_btn_text", 60)->nullable();
            $table->string("first_btn_color", 10)->nullable();
            $table->string("second_btn_color", 10)->nullable();
            $table->string("primary_color", 10)->default('002411')->nullable();
            $table->string("secondary_color", 10)->default('fcd957')->nullable();
            $table->string("middle_title", 200)->nullable();
            $table->text("video_link")->nullable();
            $table->text("imaage_1")->nullable();
            $table->text("imaage_2")->nullable();
            $table->string("faq_title", 200)->nullable();
            $table->string("contact_info", 200)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('landing_pages');
    }
}
