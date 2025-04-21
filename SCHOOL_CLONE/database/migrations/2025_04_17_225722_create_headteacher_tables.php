<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Staff Reports Table
        Schema::create('staff_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('content');
            $table->enum('status', ['pending', 'approved', 'rejected', 'reviewed'])->default('pending');
            $table->text('headteacher_comments')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();
        });

        // Report Comments Table
        Schema::create('report_comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('staff_reports')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->text('comment');
            $table->string('status_change')->nullable();
            $table->timestamps();
        });

        

        Schema::table('announcements', function (Blueprint $table) {
            $table->string('attachment_path')->nullable()->after('content');
            $table->boolean('is_circular')->default(false)->after('is_active');
        });
    }

    public function down()
    {
        Schema::dropIfExists('report_comments');
        Schema::dropIfExists('staff_reports');
        
        
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropColumn(['attachment_path', 'is_circular']);
        });
    }
};