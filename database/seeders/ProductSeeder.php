<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $menGraphic = Category::where('slug', 'men-graphic')->first() ?? Category::where('slug', 'men')->first();
        $menBasic = Category::where('slug', 'men-basic')->first() ?? Category::where('slug', 'men')->first();
        $womenOversize = Category::where('slug', 'women-oversize')->first() ?? Category::where('slug', 'women')->first();
        $customCat = Category::where('slug', 'custom')->first();
        $hoodieCat = Category::where('slug', 'hoodies')->first() ?? Category::where('slug', 'hoodie')->first();

        // Product 1: تیشرت طرح اختصاصی وارن
        $p1 = Product::create([
            'category_id' => $menGraphic?->id,
            'sku' => 'VRN-TSH-001',
            'name' => 'تیشرت پنبه‌ای طرح هنری Art Wave وارِن',
            'slug' => 'varen-art-wave-tshirt',
            'short_description' => 'تیشرت ۱۰۰٪ پنبه سوپر با چاپ ماندگار دیجیتال DTF، ضدحساسیت و بدون آبرفت.',
            'description' => 'تیشرت مدل Art Wave از کالکشن اختصاصی برند وارن (FOR YOU | WITH ART). دوخته شده از بهترین پارچه ۱۰۰٪ پنبه سوپر شانه شده با چاپ مستقیم باکیفیت و ماندگار در برابر شستشو.',
            'price' => 450000,
            'sale_price' => 380000,
            'stock' => 25,
            'featured_image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=800&q=80',
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductAttribute::create(['product_id' => $p1->id, 'attribute_name' => 'برند', 'attribute_value' => 'وارِن (VAREN)']);
        ProductAttribute::create(['product_id' => $p1->id, 'attribute_name' => 'جنس پارچه', 'attribute_value' => '۱۰۰٪ پنبه سوپر']);
        ProductAttribute::create(['product_id' => $p1->id, 'attribute_name' => 'نوع چاپ', 'attribute_value' => 'دیجیتال DTF تثبیت شده']);
        ProductAttribute::create(['product_id' => $p1->id, 'attribute_name' => 'سایزبندی', 'attribute_value' => 'M, L, XL, XXL']);

        // Product 2: چاپ طرح دلخواه
        $p2 = Product::create([
            'category_id' => $customCat?->id,
            'sku' => 'VRN-CST-002',
            'name' => 'سفارش چاپ طرح دلخواه شما روی تیشرت پنبه‌ای',
            'slug' => 'custom-print-tshirt-order',
            'short_description' => 'چاپ عکس، لوگو یا طرح دلخواه شما روی تیشرت با بالاترین وضوح رنگ و ماندگاری تضمینی.',
            'description' => 'طرح یا ایده مورد نظر خود را برای ما بفرستید تا با بالاترین رزولوشن و با استفاده از دستگاه‌های صنعتی DTF بر روی تیشرت‌های پنبه‌ای گرم‌بالای وارن چاپ و برایتان ارسال کنیم.',
            'price' => 490000,
            'sale_price' => 420000,
            'stock' => 50,
            'featured_image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=800&q=80',
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductAttribute::create(['product_id' => $p2->id, 'attribute_name' => 'برند', 'attribute_value' => 'وارِن (VAREN)']);
        ProductAttribute::create(['product_id' => $p2->id, 'attribute_name' => 'نوع سفارش', 'attribute_value' => 'طرح اختصاصی مشتری']);
        ProductAttribute::create(['product_id' => $p2->id, 'attribute_name' => 'تکنولوژی چاپ', 'attribute_value' => 'DTF صنعتی ضد شستشو']);

        // Product 3: تیشرت اورسایز زنانه
        $p3 = Product::create([
            'category_id' => $womenOversize?->id,
            'sku' => 'VRN-WTS-003',
            'name' => 'تیشرت اورسایز زنانه طرح Minimalist وارن',
            'slug' => 'women-oversize-minimal-tshirt',
            'short_description' => 'تیشرت لش و اورسایز ترند، پارچه بسیار خنک، لطیف و گرم‌بالا.',
            'description' => 'تیشرت اورسایز با استایل خیابانی مدرن، مناسب برای ست‌های کژوال و روزمره دخترانه و زنانه.',
            'price' => 470000,
            'sale_price' => 395000,
            'stock' => 20,
            'featured_image' => 'https://images.unsplash.com/photo-1529374255404-311a2a4f1fd9?w=800&q=80',
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductAttribute::create(['product_id' => $p3->id, 'attribute_name' => 'برند', 'attribute_value' => 'وارِن (VAREN)']);
        ProductAttribute::create(['product_id' => $p3->id, 'attribute_name' => 'مدل', 'attribute_value' => 'اورسایز (Oversize)']);
        ProductAttribute::create(['product_id' => $p3->id, 'attribute_name' => 'سایز', 'attribute_value' => 'فری سایز']);

        // Product 4: هودی کلاه‌دار
        $p4 = Product::create([
            'category_id' => $hoodieCat?->id,
            'sku' => 'VRN-HOD-004',
            'name' => 'هودی کلاه‌دار توکرکی ۳ نخ با چاپ اختصاصی VAREN',
            'slug' => 'varen-cotton-hoodie-sweatshirt',
            'short_description' => 'هودی فوق‌العاده گرم ۳ نخ خارخورده توکرکی، دوخت دوبل و جیب کانگورویی.',
            'description' => 'هودی زمستانه وارن مناسب روزهای سرد سال با تنخور لش و دوخت بسیار تمیز به همراه چاپ ماندگار.',
            'price' => 890000,
            'sale_price' => 780000,
            'stock' => 14,
            'featured_image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=800&q=80',
            'is_active' => true,
            'is_featured' => true,
        ]);

        ProductAttribute::create(['product_id' => $p4->id, 'attribute_name' => 'برند', 'attribute_value' => 'وارِن (VAREN)']);
        ProductAttribute::create(['product_id' => $p4->id, 'attribute_name' => 'پارچه', 'attribute_value' => '۳ نخ پنبه توکرکی']);

        // Product 5: تیشرت بیسیک مشکی
        $p5 = Product::create([
            'category_id' => $menBasic?->id,
            'sku' => 'VRN-BSC-005',
            'name' => 'تیشرت بیسیک پنبه‌ای خالص رنگ مشکی عمیق',
            'slug' => 'basic-black-cotton-tshirt',
            'short_description' => 'تیشرت ساده و شیک بدون چاپ با پنبه سوپر درجه یک بدون پرزدهی.',
            'description' => 'تیشرت بیسیک یقه گرد با تنخور استاندارد و پارچه سبک و تنفس‌پذیر.',
            'price' => 380000,
            'sale_price' => 330000,
            'stock' => 40,
            'featured_image' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=800&q=80',
            'is_active' => true,
            'is_featured' => true,
        ]);
        ProductAttribute::create(['product_id' => $p5->id, 'attribute_name' => 'برند', 'attribute_value' => 'وارِن (VAREN)']);
        ProductAttribute::create(['product_id' => $p5->id, 'attribute_name' => 'رنگ', 'attribute_value' => 'مشکی']);
    }
}


