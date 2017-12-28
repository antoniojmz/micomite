<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class sessions extends Model
{
    //
		Schema::create('sessions', function ($table) {
	    $table->string('id')->unique();
	    $table->integer('user_id')->nullable();
	    $table->string('ip_address', 45)->nullable();
	    $table->text('user_agent')->nullable();
	    $table->text('payload');
	    $table->integer('last_activity');
	});

}
