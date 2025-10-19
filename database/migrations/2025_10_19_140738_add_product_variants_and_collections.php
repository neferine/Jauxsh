<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Product Variants Table (for sizes and colors)
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('sku')->unique(); // e.g., "TSHIRT-BLK-M"
            $table->string('size')->nullable(); // S, M, L, XL, etc.
            $table->string('color')->nullable(); // Black, White, Red, etc.
            $table->string('color_hex')->nullable(); // #000000 for display
            $table->decimal('price_adjustment', 10, 2)->default(0); // +/- from base price
            $table->integer('stock')->default(0);
            $table->string('image_url')->nullable(); // Variant-specific image
            $table->timestamps();
            
            // Ensure unique combinations per product
            $table->unique(['product_id', 'size', 'color']);
        });

        // Collections Table
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable(); // Collection banner
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Collection-Product Pivot Table (many-to-many)
        Schema::create('collection_product', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->integer('sort_order')->default(0); // Order within collection
            $table->timestamps();
            
            $table->unique(['collection_id', 'product_id']);
        });

        // Update cart_items to reference variants
        Schema::table('cart_items', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('product_id')
                  ->constrained('product_variants')->onDelete('cascade');
        });

        // Update order_items to reference variants
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('product_variant_id')->nullable()->after('product_id')
                  ->constrained('product_variants')->onDelete('cascade');
            $table->string('size')->nullable(); // Store for history
            $table->string('color')->nullable(); // Store for history
        });
    }

    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn(['product_variant_id', 'size', 'color']);
        });
        
        Schema::table('cart_items', function (Blueprint $table) {
            $table->dropForeign(['product_variant_id']);
            $table->dropColumn('product_variant_id');
        });
        
        Schema::dropIfExists('collection_product');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('product_variants');
    }
};