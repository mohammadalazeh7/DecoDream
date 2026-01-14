<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use Illuminate\Http\Request;

class DashboardcomplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with('user')->orderBy('id', 'desc');

        if ($request->filled('complaint_id')) {
            $query->where('id', $request->complaint_id);
        }

        if ($request->filled('user_name')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->user_name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('complaint_id')) {
            return redirect()->route('complaints.index')
                ->with('error', 'No results found according to your search');
        }
        if ($request->filled('user_name')) {
            return redirect()->route('complaints.index')
                ->with('error', 'No results found according to your search');
        }
        //  if ($request->filled('status')) {
        //     return redirect()->route('complaints.index')
        //         ->with('error', ' لا توجد نتائج مطابقة للبحث ');
        // }

        $complaints = $query->paginate(10)->appends($request->all());
        
        return view('admin.complaints.index', compact('complaints'));
    }
    public function edit($id)
    {
        $complaint = Complaint::with(['user'])->findOrFail($id);
        return view('admin.complaints.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->update($request->all());
        return redirect()->route('complaints.index', $complaint->id)->with('success', 'Complaint updated successfully.');


    }

}
