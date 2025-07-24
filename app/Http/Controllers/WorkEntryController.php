<?php

namespace App\Http\Controllers;

use App\Models\WorkEntry;
use App\Http\Requests\StoreWorkEntryRequest;
use App\Http\Requests\UpdateWorkEntryRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\json;

class WorkEntryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkEntryRequest $request)
    {
        $fields = $request->validated();
        $fields['worker_id'] = Auth::id();
        $completedAt = $request->input('completed') == true ? Carbon::now() : null; // Set completed_at if completed is true

        $WorkEntry = WorkEntry::create($fields);

        $missionTask = $WorkEntry->missionTask; // Assuming WorkEntry has a relation to MissionTask
        if ($missionTask) {
            $missionTask->update(['status' => 'en_cours', 'completed_at' => $completedAt]); // Update status and completed_at if applicable
        }

        // Optionally, you can redirect or return a response here
        return redirect()->back()->with('success', 'Entrée enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkEntry $workEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkEntry $workEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkEntryRequest $request, WorkEntry $workEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkEntry $workEntry)
    {
        //
    }
}
