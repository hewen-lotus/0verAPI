<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdmissionPlacementStepQuotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admission_placement_step_quota', function (Blueprint $table) {
            $table->string('dept_id')->primary()->comment('系所代碼');
            $table->integer('s1')->comment('第一梯次(s1)：馬來西亞(持華文獨中統考文憑)');
            $table->integer('s2')->comment('第二梯次(s2)：馬來西亞(STPM/A-LEVEL/O-LEVEL/SPM)、一般地區(歐洲、美洲、非洲、大洋洲及其他免試地區)');
            $table->integer('s3')->comment('第三梯次(s3)：海外測驗(日本、韓國、菲律賓、新加坡、泰北、緬甸、海外臺灣學校高中畢業生及澳門)');
            $table->integer('s4')->comment('第四梯次(s4)：國立臺灣師範大學僑生先修部結業生');
            $table->integer('s5')->comment('第五梯次(s5)：印尼輔訓班結業生、香港');
            $table->foreign('dept_id')->references('id')->on('department_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admission_placement_step_quota', function (Blueprint $table) {
            $table->dropForeign('admission_placement_step_quota_dept_id_foreign');
        });

        Schema::dropIfExists('admission_placement_step_quota');
    }
}
