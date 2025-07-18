<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Comment;
use App\Models\Department;
use App\Models\Member;
use App\Models\Mission;
use App\Models\MissionTask;
use App\Models\Planning;
use App\Models\PredefinedTasks;
use App\Models\Structure;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\WorkEntry;
use Illuminate\Database\Seeder;
use Illuminate\Hashing\HashServiceProvider;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        // Ensure roles exist before assigning them
        Role::firstOrCreate(['name' => 'worker']);
        Role::firstOrCreate(['name' => 'manager']);
        Role::firstOrCreate(['name' => 'admin']);

        // --- 2. Create Users and Assign Roles ---
        // Retrieve or create users to ensure we have them for relationships
        $manager1 = User::firstOrCreate(
            ['email' => 'manager1@manager.com'],
            ['name' => 'Manager 1', 'password' => Hash::make('password')]
        );
        $manager1->assignRole('manager');
        $manager2 = User::firstOrCreate(
            ['email' => 'manager2@manager.com'],
            ['name' => 'Manager 2', 'password' => Hash::make('password')]
        );
        $manager2->assignRole('manager');

        $worker1 = User::firstOrCreate(
            ['email' => 'worker1@worker.com'],
            ['name' => 'Worker 1', 'password' => Hash::make('password')]
        );
        $worker1->assignRole('worker');

        $worker2 = User::firstOrCreate(
            ['email' => 'worker2@worker.com'],
            ['name' => 'Worker 2', 'password' => Hash::make('password')]
        );
        $worker2->assignRole('worker');

        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        $admin->assignRole('admin');

        // Get all worker users for later assignments
        $workers = User::role('worker')->get();

        // --- 3. Seed Departments (3) ---
        $department1 = Department::firstOrCreate(['name' => 'Audit']);
        $department2 = Department::firstOrCreate(['name' => 'Fiscalité']);
        $department3 = Department::firstOrCreate(['name' => 'Conseil']);

        $departments = Department::all(); // Get all departments for random selection

        // --- 4. Seed TaskTypes (4) ---
        // Link TaskTypes to Departments
        $taskType1 = PredefinedTasks::firstOrCreate([
            'name' => 'Vérification des comptes',
            'description' => 'Vérification des écritures comptables et des pièces justificatives.',
            'department_id' => $department1->id, // Audit
        ]);
        $taskType2 = PredefinedTasks::firstOrCreate([
            'name' => 'Déclaration TVA',
            'description' => 'Préparation et soumission des déclarations de TVA.',
            'department_id' => $department2->id, // Fiscalité
        ]);
        $taskType3 = PredefinedTasks::firstOrCreate([
            'name' => 'Analyse Financière',
            'description' => 'Analyse des états financiers pour des recommandations.',
            'department_id' => $department3->id, // Conseil
        ]);
        $taskType4 = PredefinedTasks::firstOrCreate([
            'name' => 'Saisie de données',
            'description' => 'Saisie de documents et informations dans le système.',
            'department_id' => $department1->id, // Can be used across departments, linking to Audit for example
        ]);

        $taskTypes = PredefinedTasks::all(); // Get all task types for random selection

        // --- 5. Seed Clients (2) ---
        $client1 = Client::firstOrCreate([
            'name' => 'SARL InnovTech',
            'contact_person' => 'Jean Dupont',
            'email' => 'contact@innovtech.com',
            'phone' => '0123456789',
        ]);
        $client2 = Client::firstOrCreate([
            'name' => 'EURL VertJardin',
            'contact_person' => 'Sophie Martin',
            'email' => 'info@vertjardin.fr',
            'phone' => '0987654321',
        ]);

        $clients = Client::all();

        // --- 6. Seed Structures (2) ---
        $structure1 = Structure::firstOrCreate([
            'name' => 'Cabinet Principal Paris',
            'address' => '10 Rue de la Paix, 75002 Paris',
        ]);
        $structure2 = Structure::firstOrCreate([
            'name' => 'Agence Lyon',
            'address' => '25 Avenue Jean Jaurès, 69007 Lyon',
        ]);

        $structures = Structure::all();

        // --- 7. Seed Missions (2) ---
        $mission1 = Mission::firstOrCreate([
            'name' => 'Audit Annuel InnovTech 2024',
            'description' => 'Audit légal des comptes annuels de la société InnovTech pour l\'exercice 2024.',
            'start_date' => '2025-07-01',
            'end_date' => '2025-08-31',
            'estimated_cost' => 15000.00,
            'estimated_hours' => 255,
            'status' => 'En Cours',
            'client_id' => $client1->id,
            'manager_id' => $manager2->id

        ]);
        $mission2 = Mission::firstOrCreate([
            'name' => 'Conseil Fiscal VertJardin',
            'description' => 'Mission de conseil pour l\'optimisation fiscale de l\'entreprise VertJardin.',
            'start_date' => '2025-07-15',
            'end_date' => '2025-09-30',
            'estimated_cost' => 8000.00,
            'estimated_hours' => 355,
            'status' => 'Planifiée',
            'client_id' => $client2->id,
            'manager_id' => $manager1->id

        ]);

        $missions = Mission::all();

        // --- 8. Seed MissionWorkers (2) ---
        // Assign workers to missions
        Member::firstOrCreate([
            'mission_id' => $mission1->id,
            'worker_id' => $worker1->id,
            'joined_at' => '2025-06-25',
            'role' => 'Chef de Mission Adjoint',
        ]);
        Member::firstOrCreate([
            'mission_id' => $mission1->id,
            'worker_id' => $worker2->id,
            'joined_at' => '2025-06-28',
            'role' => 'Collaborateur Junior',
        ]);
        Member::firstOrCreate([ // Worker1 also assigned to Mission2
            'mission_id' => $mission2->id,
            'worker_id' => $worker1->id,
            'joined_at' => '2025-07-10',
            'role' => 'Consultant Fiscal',
        ]);


        // --- 9. Seed MissionTasks (3) ---
        // Link MissionTasks to Missions, TaskTypes, and Workers
        $missionTask1 = MissionTask::firstOrCreate([
            'name' => 'Vérification des grands livres',
            'description' => 'Vérifier la concordance des grands livres avec les balances.',
            'due_date' => '2025-07-25',
            'status' => 'En Cours',
            'estimated_hours' => 10.0, // Added based on diagram improvement
            'mission_id' => $mission1->id,
            'task_type_id' => $taskType1->id, // Vérification des comptes (Audit)
            'assigned_worker_id' => $worker1->id,
        ]);
        $missionTask2 = MissionTask::firstOrCreate([
            'name' => 'Préparation annexe fiscale',
            'description' => 'Collecter les informations pour l\'annexe fiscale de InnovTech.',
            'due_date' => '2025-08-05',
            'status' => 'À Fair',
            'estimated_hours' => 8.0,
            'mission_id' => $mission1->id,
            'task_type_id' => $taskType2->id, // Déclaration TVA (Fiscalité) - can be used for tax annex
            'assigned_worker_id' => $worker2->id,
        ]);
        $missionTask3 = MissionTask::firstOrCreate([
            'name' => 'Recherche sur dispositifs fiscaux',
            'description' => 'Rechercher les dispositifs fiscaux applicables à VertJardin.',
            'due_date' => '2025-07-28',
            'status' => 'À Fair',
            'estimated_hours' => 12.0,
            'mission_id' => $mission2->id,
            'task_type_id' => $taskType3->id, // Analyse Financière (Conseil) - can be used for tax research
            'assigned_worker_id' => $worker1->id,
        ]);

        $missionTasks = MissionTask::all();

        // --- 10. Seed Comments (3) ---
        // Link Comments to MissionTasks and Users (authors)
        Comment::firstOrCreate([
            'content' => 'Vérification des 3 premiers mois terminée, tout est conforme.',
            'created_at' => '2025-07-10 10:00:00',
            'author_id' => $worker1->id,
            'mission_task_id' => $missionTask1->id,
        ]);
        Comment::firstOrCreate([
            'content' => 'N\'oubliez pas de vérifier les amortissements exceptionnels.',
            'created_at' => '2025-07-10 11:30:00',
            'author_id' => $manager1->id,
            'mission_task_id' => $missionTask1->id,
        ]);
        Comment::firstOrCreate([
            'content' => 'J\'ai commencé la recherche, quelques pistes intéressantes.',
            'created_at' => '2025-07-16 14:00:00',
            'author_id' => $worker1->id,
            'mission_task_id' => $missionTask3->id,
        ]);

        // --- 11. Seed Planning (2) ---
        // Link Planning to Manager, Worker, and Mission
        Planning::firstOrCreate([
            'planning_date' => '2025-07-18',
            'details' => 'Pour aujourd\'hui, concentrez-vous sur la vérification des grands livres pour InnovTech. Assurez-vous de couvrir les transactions importantes.',
            'manager_id' => $manager1->id,
            'worker_id' => $worker1->id,
            'mission_id' => $mission1->id,
        ]);
        Planning::firstOrCreate([
            'planning_date' => '2025-07-19',
            'details' => 'Demain, commencez la préparation de l\'annexe fiscale pour InnovTech. Récupérez les documents nécessaires auprès du client.',
            'manager_id' => $manager1->id,
            'worker_id' => $worker2->id,
            'mission_id' => $mission1->id,
        ]);

        // --- 12. Seed WorkEntry (3) ---
        // Link WorkEntry to MissionTask and Worker
        WorkEntry::firstOrCreate([
            'entry_date' => '2025-07-17 09:00:00',
            'hours_worked' => 4.5,
            'description' => 'Vérification des comptes du T1 pour InnovTech.',
            'mission_task_id' => $missionTask1->id,
            'worker_id' => $worker1->id,
        ]);
        WorkEntry::firstOrCreate([
            'entry_date' => '2025-07-17 14:00:00',
            'hours_worked' => 3.0,
            'description' => 'Recherche initiale sur les dispositifs fiscaux pour VertJardin.',
            'mission_task_id' => $missionTask3->id,
            'worker_id' => $worker1->id,
        ]);
        WorkEntry::firstOrCreate([
            'entry_date' => '2025-07-18 09:30:00',
            'hours_worked' => 2.0,
            'description' => 'Suite de la vérification des grands livres, focus sur les immobilisations.',
            'mission_task_id' => $missionTask1->id,
            'worker_id' => $worker1->id,
        ]);

        $this->command->info('Database seeded successfully!');
    }
}
