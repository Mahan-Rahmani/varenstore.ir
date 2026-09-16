<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Slider extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'tag',
        'button_text',
        'link',
        'image',
        'mobile_image',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }

    protected static function booted()
    {
        static::ensureTableExists();
    }

    public static function ensureTableExists(): void
    {
        try {
            if (!Schema::hasTable('sliders')) {
                Schema::create('sliders', function ($table) {
                    $table->id();
                    $table->string('title')->nullable();
                    $table->string('subtitle')->nullable();
                    $table->string('tag')->nullable();
                    $table->string('button_text')->nullable()->default('مشاهده و خرید');
                    $table->string('link')->nullable();
                    $table->text('image');
                    $table->text('mobile_image')->nullable();
                    $table->integer('sort_order')->default(0);
                    $table->boolean('is_active')->default(true);
                    $table->timestamps();
                });

                // Seed initial default slides
                static::create([
                    'title' => 'تیشرت‌های اختصاصی وارِن | VAREN',
                    'subtitle' => '۱۰۰٪ پنبه سوپر با ماندگارترین کیفیت چاپ و طراحی‌های ترند هنری',
                    'tag' => 'کالکشن جدید وارن',
                    'button_text' => 'مشاهده و خرید',
                    'image' => 'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?w=1600&q=80',
                    'link' => '/?category=men',
                    'sort_order' => 1,
                    'is_active' => true,
                ]);

                static::create([
                    'title' => 'چاپ طرح دلخواه شما روی تیشرت',
                    'subtitle' => 'هر طرح، ایده یا عکسی که دوست دارید با بالاترین رزولوشن و دوام شستشو',
                    'tag' => 'سفارش اختصاصی DTF',
                    'button_text' => 'سفارش آنلاین',
                    'image' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=1600&q=80',
                    'link' => '/?category=custom',
                    'sort_order' => 2,
                    'is_active' => true,
                ]);

                static::create([
                    'title' => 'هودی و دورس‌های پاییزی و زمستانه',
                    'subtitle' => 'تنخور فوق‌العاده، دوخت تمیز و مناسب برای استایل روزمره و استریت‌ویر',
                    'tag' => 'FOR YOU | WITH ART',
                    'button_text' => 'مشاهده کالکشن',
                    'image' => 'https://images.unsplash.com/photo-1556905055-8f358a7a47b2?w=1600&q=80',
                    'link' => '/?category=hoodie',
                    'sort_order' => 3,
                    'is_active' => true,
                ]);
            }
        } catch (\Throwable $e) {
            // Silence exception if schema operation is constrained
        }
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc')->orderBy('id', 'desc');
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return asset('images/placeholder.jpg');
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset('storage/' . ltrim($this->image, '/'));
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        if (empty($this->mobile_image)) {
            return $this->image_url;
        }

        if (str_starts_with($this->mobile_image, 'http://') || str_starts_with($this->mobile_image, 'https://')) {
            return $this->mobile_image;
        }

        return asset('storage/' . ltrim($this->mobile_image, '/'));
    }
}
