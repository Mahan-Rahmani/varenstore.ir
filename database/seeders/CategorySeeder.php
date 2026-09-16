<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. تیشرت مردانه
        $men = Category::create([
            'name' => 'تیشرت مردانه',
            'slug' => 'men',
            'description' => 'انواع تیشرت‌های پنبه‌ای مردانه در طرح‌ها و رنگ‌های متنوع',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Category::create(['parent_id' => $men->id, 'name' => 'تیشرت بیسیک و ساده', 'slug' => 'men-basic', 'sort_order' => 1, 'is_active' => true]);
        Category::create(['parent_id' => $men->id, 'name' => 'تیشرت طرح‌دار گرافیکی', 'slug' => 'men-graphic', 'sort_order' => 2, 'is_active' => true]);
        Category::create(['parent_id' => $men->id, 'name' => 'تیشرت لانگ و لش', 'slug' => 'men-long', 'sort_order' => 3, 'is_active' => true]);

        // 2. تیشرت زنانه و اورسایز
        $women = Category::create([
            'name' => 'تیشرت زنانه و اورسایز',
            'slug' => 'women',
            'description' => 'تیشرت‌های ترند زنانه، کراپ و مدل‌های جذاب اورسایز',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Category::create(['parent_id' => $women->id, 'name' => 'تیشرت اورسایز (Oversize)', 'slug' => 'women-oversize', 'sort_order' => 1, 'is_active' => true]);
        Category::create(['parent_id' => $women->id, 'name' => 'کراپ تیشرت', 'slug' => 'women-crop', 'sort_order' => 2, 'is_active' => true]);
        Category::create(['parent_id' => $women->id, 'name' => 'تیشرت‌های مینیمال و هنری', 'slug' => 'women-minimal', 'sort_order' => 3, 'is_active' => true]);

        // 3. چاپ طرح دلخواه
        Category::create([
            'name' => 'چاپ طرح دلخواه شما',
            'slug' => 'custom',
            'description' => 'سفارش آنلاین چاپ عکس، لوگو، نوشته یا طرح اختصاصی روی تیشرت با چاپ DTF ماندگار',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 4. هودی و دورس
        $hoodie = Category::create([
            'name' => 'هودی و دورس',
            'slug' => 'hoodie',
            'description' => 'هودی و دورس‌های ۳ نخ پنبه گرم مناسب پاییز و زمستان با چاپ اختصاصی',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        Category::create(['parent_id' => $hoodie->id, 'name' => 'هودی کلاه‌دار', 'slug' => 'hoodies', 'sort_order' => 1, 'is_active' => true]);
        Category::create(['parent_id' => $hoodie->id, 'name' => 'دورس پاییزه', 'slug' => 'sweatshirts', 'sort_order' => 2, 'is_active' => true]);
    }
}


