<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->text('header_logo')->nullable();
            $table->text('footer_logo')->nullable();
            $table->text('fabicon')->nullable();
            $table->text('breaking_news')->nullable();
            $table->text('footer_short_description')->nullable();
            $table->text('address')->nullable();

            $table->text('phone_number_1')->nullable();
            $table->text('phone_number_2')->nullable();
            $table->text('phone_number_3')->nullable();

            $table->text('phone_number_desktop')->nullable();
            $table->text('phone_number_laptop')->nullable();
            $table->text('phone_number_service')->nullable();
            $table->text('phone_number_accessories')->nullable();
            $table->text('phone_number_helpline')->nullable();
            $table->text('phone_number_rma')->nullable();

            $table->text('email_1')->nullable();
            $table->text('email_2')->nullable();
            $table->text('email_3')->nullable();

            $table->text('side_banner_left_top')->nullable();
            $table->text('side_banner_left_bottom')->nullable();
            $table->text('side_banner_right_top')->nullable();
            $table->text('side_banner_right_bottom')->nullable();

            $table->text('header_background_color')->nullable();
            $table->text('header_text_color')->nullable();

            $table->text('nav_background_color')->nullable();
            $table->text('nav_text_color')->nullable();

            $table->text('dropdown_background_color')->nullable();
            $table->text('dropdown_heading_color')->nullable();
            $table->text('dropdown_text_color')->nullable();

            $table->text('website_brand_color')->nullable();
            $table->text('website_text_color')->nullable();
            $table->text('website_text_hover_color')->nullable();
            $table->text('website_hover_background_color')->nullable();

            $table->longText('short_about')->nullable();
            $table->longText('descriptive_about')->nullable();

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
        Schema::dropIfExists('settings');
    }
}
