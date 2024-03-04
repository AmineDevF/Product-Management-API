<?php

use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
        $table->id();
        // $table->bigInteger('user_id')->unsigned();
        // $table->bigInteger('product_id')->unsigned();
        $table->decimal('subtotal');
        $table->decimal('discount')->default(0);
        $table->decimal('tax');
        $table->decimal('total');
        $table->enum('status',['pandding','success','canceled'])->default('pandding');
        $table->foreignIdFor(User::class, 'created_by')->nullable();
        $table->foreignIdFor(User::class, 'updated_by')->nullable();
        // $table->date('shipping_date')->nullable();
        // $table->date('canceled_date')->nullable();
        // $table->foreignId('product_id')->references('id')->on('products');
        // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
