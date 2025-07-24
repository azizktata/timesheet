<?php

namespace App\Http\Controllers;

use App\Models\MissionTask;
use App\Models\WorkEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class WorkerController extends Controller
{
    public function index(Request $request)
    {
        $dateRange = $request->input('dateRange');
        $startDate = isset($dateRange['from'])
            ? Carbon::parse($dateRange['from'])->startOfDay()->format('Y-m-d')
            : Carbon::now()->startOfWeek()->format('Y-m-d');

        $endDate = isset($dateRange['to'])
            ? Carbon::parse($dateRange['to'])->endOfDay()->format('Y-m-d')
            : Carbon::now()->endOfWeek()->format('Y-m-d');

        $loggedUser = Auth::user();
        $totalHoursWorked = WorkEntry::where('worker_id', $loggedUser->id)
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->sum('hours_worked'); // Assuming 'hours_worked' is the field storing hours

        $tasksCompleted = WorkEntry::with('missionTask')->where('worker_id', $loggedUser->id)
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->whereHas('missionTask', function ($query) {
                $query->whereNotNull('completed_at');
            })
            ->count(); // Count of completed tasks

        $totalTasks = MissionTask::where('assigned_worker_id', $loggedUser->id)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->count(); // Total tasks assigned to the worker in the date range

        $hoursEstimated = MissionTask::where('assigned_worker_id', $loggedUser->id)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->sum('estimated_hours'); // Assuming 'estimated_hours' is the field for estimated hours

        $hoursVsEstimatedPercentage = $hoursEstimated > 0 ? round(($totalHoursWorked / $hoursEstimated) * 100, 2) : 0;

        // i want to get hours worked distribution by mission 
        $workEntries = WorkEntry::where('worker_id', $loggedUser->id)
            ->whereBetween('entry_date', [$startDate, $endDate])
            ->with('missionTask', 'missionTask.mission', 'missionTask.taskType')
            ->get();
        $workEntries->transform(function ($entry) {
            $entry->missionName = $entry->missionTask->mission->name ?? 'N/A';
            $entry->estimatedHours = $entry->missionTask->mission->estimated_hours ?? 0;
            $entry->taskName = $entry->missionTask->name ?? 'N/A';
            $entry->taskType = $entry->missionTask->taskType->name ?? 'N/A';
            $entry->hoursWorked = $entry->hours_worked; // Assuming 'hours_worked' is the field storing hours
            return $entry;
        });
        // group by missionName
        $workEntriesGrouped = $workEntries->groupBy('missionName');
        $pieData1 = $workEntriesGrouped->map(function ($entries, $missionName) {
            return [
                'label' => $missionName,
                'value' => $entries->sum('hoursWorked'),
            ];
        })->values()->toArray();

        // group by taskType
        $workEntriesGroupedByTaskType = $workEntries->groupBy('taskType');
        $pieData2 = $workEntriesGroupedByTaskType->map(function ($entries, $taskType) {
            return [
                'label' => $taskType,
                'value' => $entries->sum('hoursWorked'),
            ];
        })->values()->toArray();

        return Inertia::render('profile/index', compact('totalHoursWorked', 'tasksCompleted', 'hoursEstimated', 'hoursVsEstimatedPercentage', 'totalTasks', 'startDate', 'endDate', 'workEntries', 'pieData1', 'pieData2'));
    }
}
