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
        Schema::create('activities', function (Blueprint $table) {
            $table->id();

            // العميل
            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            // المستخدم الذي قام بالنشاط
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // نوع التواصل
            $table->enum('type', [
                'call',
                'whatsapp',
                'sms',
                'email',
                'meeting',
                'other',
            ]);

            // نتيجة التواصل
            $table->enum('result', [
                'contacted',
                'interested',
                'follow_up',
                'no_answer',
                'phone_closed',
                'wrong_number',
                'not_interested',
                'converted',
                'other',
            ])->nullable();

            // تفاصيل التواصل
            $table->text('notes')->nullable();

            // تاريخ التواصل
            $table->timestamp('contacted_at');

            // موعد المتابعة القادمة
            $table->timestamp('next_follow_up_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
