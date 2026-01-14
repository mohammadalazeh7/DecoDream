<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\DashboardWoodRequest;
use App\Models\Wood;
use App\Services\DashboardWoodService;
use Illuminate\Http\Request;

class DashboardWoodController extends Controller
{
    //

    protected $woodServies;
    public function __construct(DashboardWoodService $woodServies)
    {
        $this->woodServies = $woodServies;
    }
    public function index(Request $request)
    {
        // $woods = $this->woodServies->getAll();
        $query = $this->woodServies->getAll();

        if ($request->filled('wood_type')) {
            $query->where('wood_type', 'like', '%' . $request->wood_type . '%');
        }

        if ($request->filled('wood_type')) {
            return redirect()->route('woods.index')
                ->with('error', 'No results found according to your search');
        }

        $woods = $query->paginate(10)
            ->appends($request->except('page'));


        return view('admin.woods.index', compact('woods'));
    }
    public function create()
    {
        return view('admin.woods.create');
    }
    public function store(DashboardWoodRequest $request)
    {
        $this->woodServies->create($request->validated());
        return redirect()->route('woods.index')
            ->with('success', 'Wood created successfully.');
    }
    public function edit(Wood $wood)
    {
        return view('admin.woods.edit', compact('wood'));
    }
    public function update(DashboardWoodRequest $request, Wood $wood)
    {
        $this->woodServies->update($request->validated(), $wood);
        return redirect()->route('woods.index')
            ->with('success', 'Wood updated successfully.');
    }

    public function destroyd(Wood $wood)
    {
        $this->woodServies->delete($wood);
        return redirect()->route('woods.index')
            ->with('success', 'Wood deleted successfully.');
    }
    public function destroy(Wood $wood)
    {
        $deleted = $this->woodServies->delete($wood);

        // if (!$deleted) {
        //     return redirect()->route('woods.index')
        //         ->with('error', 'Cannot delete wood. There are products associated with this wood.');
        // }

        return redirect()->route('woods.index')
            ->with('success', 'Woods deleted successfully.');
    }


    public function delete(Wood $wood)
    {
        return view('admin.woods.delete', compact('wood'));
    }


}
