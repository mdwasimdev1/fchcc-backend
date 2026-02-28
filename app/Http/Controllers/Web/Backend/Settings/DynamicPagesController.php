<?php

namespace App\Http\Controllers\Web\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use Illuminate\Http\Request;

class DynamicPagesController extends Controller
{
    public function index()
    {
        return view('backend.layout.setting.dynamic_page.index');
    }

    public function getdata()
    {
        $dynamicPages = DynamicPage::query();
        return datatables()->of($dynamicPages)
            ->addIndexColumn()


            ->editColumn('status', function ($row) {
                $checked = $row->status == 'active' ? 'checked' : '';
                return '
                  <div class="form-check form-switch"> 
                       <input type="checkbox"
                          class="form-check-input status-toggle"
                          data-id="' . $row->id . '"
                          data-model="DynamicPage"
                          data-url="' . route('dynamicpages.status') . '"
                         ' . $checked . '>
                  </div>
                   ';
            })
            ->rawColumns(['status'])

            ->addColumn('page_content', function ($row) {
                return strip_tags($row->page_content);
            })
            ->addColumn('action', function ($row) {
                return '
                <div class="d-flex align-items-center gap-1 justify-content-end">
                 <a href="' . route('dynamicpages.edit', $row->id) . '" class="btn btn-sm btn-outline-primary me-1">
                    <i class="fa fa-edit"></i>
                 </a>
                <button class="btn btn-sm btn-outline-danger delete-item"
                        data-id="' . $row->id . '"
                        data-url="' . route('dynamicpages.destroy') . '">
                        <i class="fa fa-trash"></i>
                 </button>
               </div>
            ';
            })
            ->rawColumns(['status', 'action'])
            ->make(true);
    }





    public function create()
    {
        return view('backend.layout.setting.dynamic_page.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'page_title' => 'required|string|max:255',
            'page_content' => 'required|string',
        ]);

        $dynamicPage = new DynamicPage();
        $dynamicPage->page_title = $request->page_title;

        $dynamicPage->page_content = $request->page_content;
        $dynamicPage->save();
        return redirect()->route('dynamicpages.index')->with('success', 'Dynamic Page created successfully.');
    }




    public function edit($id)
    {
        $page = DynamicPage::findOrFail($id);

        return view('backend.layout.setting.dynamic_page.edit', compact('page'));
    }



    public function update(Request $request, $id)
    {
        $request->validate([
            'page_title' => 'required|string|max:255',
            'page_content' => 'required|string',
        ]);

        $dynamicPage = DynamicPage::findOrFail($id);
        $dynamicPage->page_title = $request->page_title;
        $dynamicPage->page_content = $request->page_content;
        $dynamicPage->save();

        return redirect()->route('dynamicpages.index')->with('success', 'Dynamic Page updated successfully.');
    }


    public function changeStatus(Request $request)
    {
        $dynamicPage = DynamicPage::findOrFail($request->id);
        $dynamicPage->status = $dynamicPage->status == 'active' ? 'inactive' : 'active';
        $dynamicPage->save();

        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    }


    public function destroy(Request $request)
    {
        try {

            $dynamicPage = DynamicPage::findOrFail($request->id);

            if (!$dynamicPage) {
                return response()->json([
                    'success' => false,
                    'message' => 'Dynamic Page not found!'
                ]);
            }

            $dynamicPage->delete();

            return response()->json([
                'success' => true,
                'message' => 'Dynamic Page deleted successfully!'
            ]);
        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }

}
