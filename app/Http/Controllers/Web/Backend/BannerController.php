<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\CommunityBanner;
use App\Models\DiscountBanner;
use App\Models\EventBanner;
use App\Models\HomeBanner;
use App\Models\PartnerBanner;
use App\Models\ScholarshipBanner;
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

// Partner Banner Methods
    public function editPartnerBanner()
    {
        $banner = PartnerBanner::with('translations')->first();

        // Create a default banner if it doesn't exist
        if (!$banner) {
            $banner = PartnerBanner::create([
                'image' => null,
                'button_url' => null,
                'status' => true,
            ]);

            // Create default translations
            $banner->translations()->createMany([
                ['locale' => 'en', 'title' => '', 'description' => '', 'button_text' => ''],
                ['locale' => 'es', 'title' => '', 'description' => '', 'button_text' => ''],
            ]);

            $banner = $banner->fresh('translations');
        }

        return view('backend.layout.banners.partner', compact('banner'));
    }


    public function editCommunityBanner()
    {
        $banner = CommunityBanner::with('translations')->first();

        if (!$banner) {
            $banner = CommunityBanner::create([
                'image' => null,
                'button_url' => null,
                'status' => true,
            ]);

            $banner->translations()->createMany([
                ['locale' => 'en', 'title' => '', 'description' => '', 'button_text' => ''],
                ['locale' => 'es', 'title' => '', 'description' => '', 'button_text' => ''],
            ]);

            $banner = $banner->fresh('translations');
        }

        return view('backend.layout.banners.community', compact('banner'));
    }


    public function updateCommunityBanner(Request $request, $id)
    {
        $banner = CommunityBanner::findOrFail($id);

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

        $banner->translations()->firstOrCreate(['locale' => 'en'])->update([
            'title' => $validated['title_en'] ?? null,
            'description' => $validated['description_en'] ?? null,
            'button_text' => $validated['button_text_en'] ?? null,
        ]);

        $banner->translations()->firstOrCreate(['locale' => 'es'])->update([
            'title' => $validated['title_es'] ?? null,
            'description' => $validated['description_es'] ?? null,
            'button_text' => $validated['button_text_es'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Community banner updated successfully!');
    }

    public function editScholarshipBanner()
    {
        $banner = ScholarshipBanner::with('translations')->first();

        if (!$banner) {
            $banner = ScholarshipBanner::create([
                'image' => null,
                'button_url' => null,
                'status' => true,
            ]);

            $banner->translations()->createMany([
                ['locale' => 'en', 'title' => '', 'description' => '', 'button_text' => ''],
                ['locale' => 'es', 'title' => '', 'description' => '', 'button_text' => ''],
            ]);

            $banner = $banner->fresh('translations');
        }

        return view('backend.layout.banners.scholarship', compact('banner'));
    }

    public function updateScholarshipBanner(Request $request, $id)
    {
        $banner = ScholarshipBanner::findOrFail($id);

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

        $banner->translations()->firstOrCreate(['locale' => 'en'])->update([
            'title' => $validated['title_en'] ?? null,
            'description' => $validated['description_en'] ?? null,
            'button_text' => $validated['button_text_en'] ?? null,
        ]);

        $banner->translations()->firstOrCreate(['locale' => 'es'])->update([
            'title' => $validated['title_es'] ?? null,
            'description' => $validated['description_es'] ?? null,
            'button_text' => $validated['button_text_es'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Scholarship banner updated successfully!');
    }


    public function updatePartnerBanner(Request $request, $id)
    {
        $banner = PartnerBanner::findOrFail($id);

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

        return redirect()->back()->with('success', 'Partner banner updated successfully!');
    }

    public function editMemberBanner()
    {
        $banner = ScholarshipBanner::with('translations')->first();

        if (!$banner) {
            $banner = ScholarshipBanner::create([
                'image' => null,
                'button_url' => null,
                'status' => true,
            ]);

            $banner->translations()->createMany([
                ['locale' => 'en', 'title' => '', 'description' => '', 'button_text' => ''],
                ['locale' => 'es', 'title' => '', 'description' => '', 'button_text' => ''],
            ]);

            $banner = $banner->fresh('translations');
        }

        return view('backend.layout.banners.member', compact('banner'));
    }

    public function updateMemberBanner(Request $request, $id)
    {
        $banner = ScholarshipBanner::findOrFail($id);

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

        $banner->translations()->firstOrCreate(['locale' => 'en'])->update([
            'title' => $validated['title_en'] ?? null,
            'description' => $validated['description_en'] ?? null,
            'button_text' => $validated['button_text_en'] ?? null,
        ]);

        $banner->translations()->firstOrCreate(['locale' => 'es'])->update([
            'title' => $validated['title_es'] ?? null,
            'description' => $validated['description_es'] ?? null,
            'button_text' => $validated['button_text_es'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Member banner updated successfully!');
    }

    public function editDiscountBanner()
    {
        $banner = DiscountBanner::with('translations')->first();

        if (!$banner) {
            $banner = DiscountBanner::create([
                'image' => null,
                'button_url' => null,
                'status' => true,
            ]);

            $banner->translations()->createMany([
                ['locale' => 'en', 'title' => '', 'description' => '', 'button_text' => ''],
                ['locale' => 'es', 'title' => '', 'description' => '', 'button_text' => ''],
            ]);

            $banner = $banner->fresh('translations');
        }

        return view('backend.layout.banners.discount', compact('banner'));
    }

    public function updateDiscountBanner(Request $request, $id)
    {
        $banner = DiscountBanner::findOrFail($id);

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

        $banner->translations()->firstOrCreate(['locale' => 'en'])->update([
            'title' => $validated['title_en'] ?? null,
            'description' => $validated['description_en'] ?? null,
            'button_text' => $validated['button_text_en'] ?? null,
        ]);

        $banner->translations()->firstOrCreate(['locale' => 'es'])->update([
            'title' => $validated['title_es'] ?? null,
            'description' => $validated['description_es'] ?? null,
            'button_text' => $validated['button_text_es'] ?? null,
        ]);

        return redirect()->back()->with('success', 'Discount banner updated successfully!');
    }
}
