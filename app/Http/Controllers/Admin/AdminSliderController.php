<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminSliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::ordered()->get();
        $totalSlides = $sliders->count();
        $activeSlides = $sliders->where('is_active', true)->count();
        $inactiveSlides = $totalSlides - $activeSlides;

        return view('admin.sliders.index', compact('sliders', 'totalSlides', 'activeSlides', 'inactiveSlides'));
    }

    public function create()
    {
        $categories = Category::roots()->active()->get();
        return view('admin.sliders.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'tag' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'link' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:5120',
            'image_url' => 'nullable|string|max:1000',
            'mobile_image_file' => 'nullable|image|max:5120',
            'mobile_image_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $mainImage = $request->hasFile('image_file') 
            ? $this->uploadImage($request->file('image_file')) 
            : trim($request->input('image_url', ''));

        if (empty($mainImage)) {
            return back()->withInput()->withErrors(['image_file' => 'بارگذاری تصویر یا وارد کردن آدرس آن الزامی است.']);
        }

        $mobileImage = $request->hasFile('mobile_image_file')
            ? $this->uploadImage($request->file('mobile_image_file'))
            : trim($request->input('mobile_image_url', ''));

        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'tag' => $request->tag,
            'button_text' => $request->button_text ?: 'مشاهده و خرید',
            'link' => $request->link ?: route('home'),
            'image' => $mainImage,
            'mobile_image' => $mobileImage ?: null,
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلاید با موفقیت ثبت شد.');
    }

    public function edit(Slider $slider)
    {
        $categories = Category::roots()->active()->get();
        return view('admin.sliders.edit', compact('slider', 'categories'));
    }

    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'subtitle' => 'nullable|string|max:500',
            'tag' => 'nullable|string|max:100',
            'button_text' => 'nullable|string|max:100',
            'link' => 'nullable|string|max:500',
            'image_file' => 'nullable|image|max:5120',
            'image_url' => 'nullable|string|max:1000',
            'mobile_image_file' => 'nullable|image|max:5120',
            'mobile_image_url' => 'nullable|string|max:1000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $mainImage = $slider->image;
        if ($request->hasFile('image_file')) {
            $this->deleteOldFile($slider->image);
            $mainImage = $this->uploadImage($request->file('image_file'));
        } elseif ($request->filled('image_url')) {
            $this->deleteOldFile($slider->image);
            $mainImage = trim($request->input('image_url'));
        }

        $mobileImage = $slider->mobile_image;
        if ($request->hasFile('mobile_image_file')) {
            $this->deleteOldFile($slider->mobile_image);
            $mobileImage = $this->uploadImage($request->file('mobile_image_file'));
        } elseif ($request->filled('mobile_image_url')) {
            $mobileImage = trim($request->input('mobile_image_url'));
        } elseif ($request->boolean('remove_mobile_image')) {
            $this->deleteOldFile($slider->mobile_image);
            $mobileImage = null;
        }

        $slider->update([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'tag' => $request->tag,
            'button_text' => $request->button_text ?: 'مشاهده و خرید',
            'link' => $request->link ?: route('home'),
            'image' => $mainImage,
            'mobile_image' => $mobileImage,
            'sort_order' => (int) $request->input('sort_order', 0),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.sliders.index')->with('success', 'اسلاید با موفقیت به‌روزرسانی شد.');
    }

    public function toggle(Slider $slider)
    {
        $slider->is_active = !$slider->is_active;
        $slider->save();
        return back()->with('success', 'وضعیت اسلاید تغییر کرد.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteOldFile($slider->image);
        $this->deleteOldFile($slider->mobile_image);
        $slider->delete();
        return back()->with('success', 'اسلاید با موفقیت حذف شد.');
    }

    protected function uploadImage($file): string
    {
        $dir = public_path('uploads/sliders');
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true, true);
        }
        $filename = 'slide_' . date('Ymd_His') . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $filename);
        return asset('uploads/sliders/' . $filename);
    }

    protected function deleteOldFile(?string $path): void
    {
        if (!empty($path) && str_contains($path, 'uploads/sliders/')) {
            $file = public_path('uploads/sliders/' . basename($path));
            if (File::exists($file)) {
                File::delete($file);
            }
        }
    }
}
