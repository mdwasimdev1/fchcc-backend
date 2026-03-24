<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\EventBanner;
use App\Models\HomeBanner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function editHomeBanner()
    {

        $banner = HomeBanner::with('translations')->first();

        return view('backend.layout.banners.home', compact('banner'));
    }

    public function updateHomeBanner(Request $request, $id)
    {
        $banner = HomeBanner::findOrFail($id);

        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:12288',
            'button_url' => 'nullable|url',
            'status' => 'nullable|boolean',
            'title_en' => 'nullable|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_es' => 'nullable|string',
            'button_text_en' => 'nullable|string|max:100',
            'button_text_es' => 'nullable|string|max:100',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
                unlink(public_path('uploads/banners/' . $banner->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $imageName);
            $banner->image = $imageName;
        }

        $banner->button_url = $validated['button_url'] ?? null;
        $banner->status = $request->boolean('status');
        $banner->save();

        $enTranslation = $banner->translations()->where('locale', 'en')->first();
        if ($enTranslation) {
            $enTranslation->update([
                'title' => $validated['title_en'] ?? null,
                'description' => $validated['description_en'] ?? null,
                'button_text' => $validated['button_text_en'] ?? null,
            ]);
        }

        $esTranslation = $banner->translations()->where('locale', 'es')->first();
        if ($esTranslation) {
            $esTranslation->update([
                'title' => $validated['title_es'] ?? null,
                'description' => $validated['description_es'] ?? null,
                'button_text' => $validated['button_text_es'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Home banner updated successfully!');
    }



// Event Banner Methods
    public function editEventBanner()
    {
        $banner = EventBanner::with('translations')->first();
        return view('backend.layout.banners.event', compact('banner'));
    }


    public function updateEventBanner(Request $request, $id)
    {
        $banner = EventBanner::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:12288',
            'button_url' => 'nullable|url',
            'status' => 'nullable|boolean',
            'title_en' => 'nullable|string|max:255',
            'title_es' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_es' => 'nullable|string',
            'button_text_en' => 'nullable|string|max:100',
            'button_text_es' => 'nullable|string|max:100',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($banner->image && file_exists(public_path('uploads/banners/' . $banner->image))) {
                unlink(public_path('uploads/banners/' . $banner->image));
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/banners'), $imageName);
            $banner->image = $imageName;
        }

        $banner->button_url = $validated['button_url'] ?? null;
        $banner->status = $request->boolean('status');
        $banner->save();

        // Update translations
        $enTranslation = $banner->translations()->where('locale', 'en')->first();
        if ($enTranslation) {
            $enTranslation->update([
                'title' => $validated['title_en'] ?? null,
                'description' => $validated['description_en'] ?? null,
                'button_text' => $validated['button_text_en'] ?? null,
            ]);
        }

        $esTranslation = $banner->translations()->where('locale', 'es')->first();
        if ($esTranslation) {
            $esTranslation->update([
                'title' => $validated['title_es'] ?? null,
                'description' => $validated['description_es'] ?? null,
                'button_text' => $validated['button_text_es'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Event banner updated successfully!');
    }
}
