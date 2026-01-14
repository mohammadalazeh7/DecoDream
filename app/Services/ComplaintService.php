<?php

namespace App\Services;

use App\Models\Complaint;
use Illuminate\Support\Facades\Auth;

class ComplaintService
{
    /**
     * Store a new complaint or suggestion for the authenticated user.
     */
    public function create(array $data): Complaint
    {
        $data['user_id'] = Auth::id();
        return Complaint::create($data);
    }

    /**
     * Get all complaints (admin usage).
     */
    public function all()
    {
        return Complaint::with('user')->latest()->get();
    }

    /**
     * Get complaints for the authenticated user.
     */
    public function userComplaints()
    {
        return Complaint::where('user_id', Auth::id())->latest()->get();
    }
}
