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
        Schema::create('advs', function (Blueprint $table) {
            $table->id();
            $table->integer('section_id');
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->enum('type',['Физ.лицо','Юр.лицо'])->default('Физ.лицо');

            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('city_id')->nullable();
            //$table->string('city')->nullable();

            //Сумма инвестиций франшизы
            $table->unsignedBigInteger('investment_sum_min')->nullable();
            $table->unsignedBigInteger('investment_sum_max')->nullable();

            //Размер инвестиций
            $table->bigInteger('investment_size')->nullable();
            $table->timestamps();

            //связы
            $table->foreign('user_id')->references('id')->on('users');
            //$table->foreign('section_id')->references('id')->on('sections');
            //$table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('sub_category_id')->references('id')->on('subcategories');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('advs');
    }
};
