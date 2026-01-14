<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardFabricRequest;
use App\Models\Fabric;
use App\Services\DashboardFabricService;
use Illuminate\Http\Request;

class DashboardFabricController extends Controller
{
    //
    protected $fabricServies;
    public function __construct(DashboardFabricService $fabricServies)
    {
        $this->fabricServies = $fabricServies;
    }
    public function index(Request $request)
    {
        // $fabrics = $this->fabricServies->getAll();
        $query = $this->fabricServies->getAll();

        if ($request->filled('fabric_type')) {
            $query->where('fabric_type', 'like', '%' . $request->fabric_type . '%');
        }

        $fabrics = $query->paginate(10)
            ->appends($request->except('page'));

        if ($request->filled('fabric_type')) {
            return redirect()->route('fabrics.index')
                ->with('error', 'No results found according to your search');
        }

        return view('admin.fabrics.index', compact('fabrics'));
    }
    public function create()
    {
        return view('admin.fabrics.create');
    }
    public function store(DashboardFabricRequest $request)
    {
        $this->fabricServies->create($request->validated());
        return redirect()->route('fabrics.index')
            ->with('success', 'Fabric created successfully.');
    }
    public function edit(Fabric $fabric)
    {
        return view('admin.fabrics.edit', compact('fabric'));
    }

    public function update(DashboardFabricRequest $request, Fabric $fabric)
    {
        $this->fabricServies->update($request->validated(), $fabric);

        return redirect()->route('fabrics.index')
            ->with('success', 'Fabric updated successfully.');
    }
    public function destroy(Fabric $fabric)
    {
        $deleted = $this->fabricServies->delete($fabric);

        // if (!$deleted) {
        //     return redirect()->route('fabrics.index')
        //         ->with('error', 'Cannot delete fabric. There are products associated with this fabric.');
        // }

        return redirect()->route('fabrics.index')
            ->with('success', 'Fabric deleted successfully.');
    }

    public function delete(Fabric $fabric)
    {
        return view('admin.fabrics.delete', compact('fabric'));
    }

}
