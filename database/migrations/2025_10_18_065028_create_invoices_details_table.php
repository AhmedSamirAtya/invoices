<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->string('invoice_number', 50);
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->decimal('amount_collection',8,2)->nullable();
            $table->decimal('amount_commission',8,2);
            $table->decimal('discount',8,2);
            $table->decimal('value_vat',8,2);
            $table->string('rate_vat', 999);
            $table->decimal('total',8,2);
            $table->enum('status', ['paid', 'unpaid']);
            $table->text('note')->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();
             $table->unique('invoice_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices_details');
    }
}
