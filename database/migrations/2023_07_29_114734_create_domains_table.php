<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Slowlyo\OwlAdmin\Models\AdminMenu;
use Slowlyo\OwlAdmin\Models\AdminPermission;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ddns_domains', function (Blueprint $table) {
            $table->comment('DDNS域名列表');
            $table->increments('id');
            $table->string('cloud')->default('')->comment('云厂商');
            $table->string('appid')->default('');
            $table->string('secret')->default('');
            $table->string('domain_base')->default('')->comment('根域名');
            $table->string('domain_host')->default('');
            $table->integer('user_id');
            $table->string('token');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ddns_domains');
    }
};
