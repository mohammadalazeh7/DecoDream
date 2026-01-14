<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use App\Http\Resources\ComplaintResource;
use App\Services\ComplaintService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Auth as SupportFacadesAuth;
use Illuminate\Support\Facades\Auth;

class ComplaintController extends Controller
{
    protected $complaintService;

    public function __construct(ComplaintService $complaintService)
    {
        $this->complaintService = $complaintService;
    }

    /**
     * Store a new complaint or suggestion from the user.
     */
    public function store(Request $request)
    {
        $user = Auth::user()->id;

        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'type' => 'required|in:complaint,suggestion',
        ]);
        $validated['user_id'] = $user;
        $this->complaintService->create($validated);
        return ApiResponse::success('Complaint/Suggestion submitted successfully', 201);
    }

    /**
     * List all complaints (admin usage).
     */
    public function index()
    {
        $complaints = $this->complaintService->all();
        return ApiResponse::successWithData(ComplaintResource::collection($complaints)->toArray(request()), 'All complaints fetched', 200);
    }

    /**
     * List complaints for the authenticated user.
     */
    public function userComplaints()
    {
        $complaints = $this->complaintService->userComplaints();
        return ApiResponse::successWithData(ComplaintResource::collection($complaints)->toArray(request()), 'Your complaints fetched', 200);
    }
}
