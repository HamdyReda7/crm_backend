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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();

            // بيانات العميل
            $table->string('name');
            $table->string('phone');
            $table->string('whatsapp')->nullable();

            // نوع النشاط - يضيفه الـ Sales بنفسه
            $table->string('business_type');

            $table->string('city')->nullable();
            $table->text('address')->nullable();

            // مصدر العميل
            $table->foreignId('lead_source_id')
                ->nullable()
                ->constrained('lead_sources')
                ->nullOnDelete();

            // موظف المبيعات المسؤول
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // حالة العميل
            $table->enum('status', [
                'new',
                'contacted',
                'interested',
                'follow_up',
                'no_answer',
                'phone_closed',
                'wrong_number',
                'not_interested',
                'converted',
                'lost',
            ])->default('new');

            // ملاحظات
            $table->text('notes')->nullable();

            // التواريخ
            $table->timestamp('last_contact_at')->nullable();
            $table->timestamp('next_follow_up_at')->nullable();
            $table->timestamp('converted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
