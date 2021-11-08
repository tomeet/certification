<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificationOfficialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certification_officials', function (Blueprint $table) {
            $table->id();
            $table->bigInteger(config('certification.user_foreign_key'))->unsigned()->index()->comment('user_id');
            $table->tinyInteger('type')->unsigned()->default(0)->comment('认证类型：0公司企业，1组织团体');
            $table->string('fullname')->comment('企业或组织全名称');
            $table->mediumInteger('province_id')->unsigned()->default(0)->comment('省');
            $table->mediumInteger('city_id')->unsigned()->default(0)->comment('市');
            $table->mediumInteger('district_id')->unsigned()->nullable()->default(0)->comment('区');
            $table->string('address')->comment('详细地址');
            $table->string('unified_social_code')->index()->comment('统一社会编码：社会信用代码，营业执照号，组织机构代码');
            $table->string('business_license')->comment('营业执照');
            $table->string('authentication_letter')->comment('认证公函');
            $table->string('contact_name')->comment('联系人姓名');
            $table->string('contact_telephone')->comment('联系人电话');
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
        Schema::dropIfExists('certification_officials');
    }
}
