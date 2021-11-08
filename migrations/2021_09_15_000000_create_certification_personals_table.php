<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certification_personals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger(config('certification.user_foreign_key'))->unsigned()->index()->comment('user_id');
            $table->string('realname')->comment('真实姓名');
            $table->string('idnumber')->unique()->comment('真实姓名');
            $table->string('phone')->unique()->comment('真实姓名');
            $table->string('idcard_face')->comment('身份证正面照');
            $table->string('idcard_back')->comment('身份证背面照');
            $table->string('idcard_hand')->comment('手持身份证照');
            $table->tinyInteger('status')->nullable()->default(0)->comment('认证状态：0待审核，1已通过，-1已拒绝');
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
        Schema::dropIfExists('certification_personals');
    }
}
