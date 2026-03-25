<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\FeaturedVideo as FeaturedVideoModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class FeaturedVideo extends Controller
{
  public function index()
  {
    $video = FeaturedVideoModel::first();

    if (!$video) {
        $video = new FeaturedVideoModel([
            'title' => '',
            'video_file' => null,
            'status' => true,
        ]);
    }

    return view('backend.layout.featured-video.index', compact('video'));
  }

  public function update(Request $request){
    $request->validate([
        'title' => 'nullable|string|max:255',
        'video_file' => 'nullable|file|mimes:mp4,webm,ogg,mov,mpeg|max:51200', // max 50MB
        'status' => 'nullable|boolean',
    ]);

    try {
        $video = FeaturedVideoModel::first();

        if (!$video) {
            $video = new FeaturedVideoModel();
        }

        if ($request->hasFile('video_file')) {
            // delete old file from public/uploads if exists
            if ($video->video_file) {
                $oldPath = public_path($video->video_file);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            // new upload to public/uploads/featured-video
            $file = $request->file('video_file');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destination = public_path('uploads/featured-video');

            if (!File::exists($destination)) {
                File::makeDirectory($destination, 0755, true);
            }

            try {
                $file->move($destination, $filename);
                $video->video_file = 'uploads/featured-video/' . $filename;
            } catch (\Exception $e) {
                return back()->with('error', 'Failed to move uploaded video: ' . $e->getMessage());
            }
        }

        $video->title = $request->title ?? '';
        $video->status = $request->boolean('status');
        $video->save();

        return back()->with('success', 'Video updated successfully');
    } catch (\Exception $e) {
        return back()->with('error', 'Error uploading video: ' . $e->getMessage());
    }
  }

}

