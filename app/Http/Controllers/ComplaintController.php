<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use App\Models\User;
use App\Notifications\ComplaintStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ComplaintController extends Controller
{
    public function index()
    {
        $residentId = Auth::user()->resident->id ?? null;
        $complaints = Complaint::when(Auth::user()->role_id == 2, function ($query) use ($residentId) {
            $query->where('resident_id', $residentId);
        })->paginate(10);

        return view('pages.complaint.index', compact('complaints',));
    }

    public function create()
    {
        $resident = Auth::user()->resident;

        if (!$resident) {
            return redirect('/complaint')->with('error', 'Your account is not registered on resident data.');
        }

        return view('pages.complaint.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content'=> ['required', 'min:3', 'max:2000'],
            'photo_proof' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $resident = Auth::user()->resident;

        if (!$resident) {
            return redirect('/complaint')->with('error', 'Your account is not registered on resident data.');
        }

        $complaint = new Complaint();
        $complaint->resident_id = $resident->id;
        $complaint->title = $request->input('title');
        $complaint->content = $request->input('content');

        if ($request->hasFile('photo_proof')) {
            $filePath = $request->file('photo_proof')->store('public/uploads');
            $complaint->photo_proof = $filePath;
        }

        $complaint->save();

        return redirect('/complaint')->with('success', 'Complaint created successfully.');
    }

    public function edit($id)
    {
        $resident = Auth::user()->resident;

        if (!$resident) {
            return redirect('/complaint')->with('error', 'Your account is not registered on resident data.');
        }

        $complaint = Complaint::findOrFail($id);

        return view('pages.complaint.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'min:3', 'max:255'],
            'content'=> ['required', 'min:3', 'max:2000'],
            'photo_proof' => ['nullable', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $resident = Auth::user()->resident;

        if (!$resident) {
            return redirect('/complaint')->with('error', 'Your account is not registered on resident data.');
        }

        $complaint = Complaint::findOrFail($id);

        if($complaint->status != 'new') {
            return redirect('/complaint')->with('error', "Failed to update complaint, your complaint is $complaint->status_label.");
        }

        $complaint->resident_id = $resident->id;
        $complaint->title = $request->input('title');
        $complaint->content = $request->input('content');

        if ($request->hasFile('photo_proof')) {
            if (isset($complaint->photo_proof)) {
                Storage::delete($complaint->photo_proof);
            }
            $filePath = $request->file('photo_proof')->store('public/uploads');
            $complaint->photo_proof = $filePath;
        }

        $complaint->save();

        return redirect('/complaint')->with('success', 'Complaint updated successfully.');
    }

    public function destroy($id)
    {
        $resident = Auth::user()->resident;

        if (!$resident) {
            return redirect('/complaint')->with('error', 'Your account is not registered on resident data.');
        }

        $complaint = Complaint::findOrFail($id);

        if($complaint->status != 'new') {
            return redirect('/complaint')->with('error', "Failed to delete complaint, your complaint is $complaint->status_label.");
        }

        $complaint->delete();

        return redirect('/complaint')->with('success', 'Complaint deleted successfully.');
    }

    public function update_status(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['new', 'processing', 'completed'])],
        ]);

        $resident = Auth::user()->resident;

        if (Auth::user()->role_id == 2 && !$resident) {
            return redirect('/complaint')->with('error', 'Your account is not registered on resident data.');
        }

        $complaint = Complaint::findOrFail($id);
        $oldStatus = $complaint->status_label;

        $complaint->status = $request->input('status');
        $complaint->save();

        $newStatus = $complaint->status_label;

        User::where('id', $complaint->resident->user_id)
        ->firstOrFail()
        ->notify(new ComplaintStatusChanged($complaint, $oldStatus, $newStatus));

        return redirect('/complaint')->with('success', 'Complaint status updated successfully.');
    }
}
