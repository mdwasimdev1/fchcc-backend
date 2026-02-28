<?php

namespace App\Http\Controllers\Web\Backend\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FAQ;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::all();
        return view('backend.layout.faq.index', compact('faqs'));
    }


    public function store(Request $request)
    {

        $request->validate([
            'que' => 'required|string|max:255',
            'ans' => 'required|string|min:10',
        ]);

        $faq = new FAQ();
        $faq->que = $request->que;
        $faq->ans = $request->ans;
        $faq->save();

        return redirect()->back()->with('success', 'FAQ created successfully.');
    }




    public function status(Request $request)
    {
        $faq = FAQ::find($request->id);


        if ($faq->status == 'active') {
            $faq->update([
                'status' => 'inactive',
            ]);
        } else {
            $faq->update([
                'status' => 'active',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Status Updated'
        ]);
    }


    public function get(Request $request)
    {
        $faq = FAQ::findOrFail($request->id);
        return response()->json($faq);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:f_a_q_s,id',
            'que' => 'required|string|max:255',
            'ans' => 'required|string|min:10',
        ]);

        $faq = FAQ::findOrFail($request->id);
        $faq->update([
            'que' => $request->que,
            'ans' => $request->ans,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'FAQ updated successfully!'
        ]);
    }



    public function destroy(Request $request)
    {
        try {

            $faq = FAQ::findOrFail($request->id);

            if (!$faq) {
                return response()->json([
                    'success' => false,
                    'message' => 'FAQ not found!'
                ]);
            }

            $faq->delete();

            return response()->json([
                'success' => true,
                'message' => 'FAQ deleted successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }

    // public function destroy($id)
    // {
    //     $faq = FAQ::findOrFail($id);
    //     $faq->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'FAQ deleted successfully!'
    //     ]);
    // }

}
