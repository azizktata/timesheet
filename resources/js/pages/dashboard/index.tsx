import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, usePage } from '@inertiajs/react';
import { Dock, Workflow } from 'lucide-react';
import { SectionCards } from './cards-section';
import { MissionCard } from './mission-card';
import { TaskCard } from './task-card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

export default function Index() {
    const { workerMissions, myTasks } = usePage<PageProps>().props;

    console.log('workerMissions', workerMissions);
    console.log('myTasks', myTasks);
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Dashboard" />
            <div className="p-4">
                <SectionCards
                    metric_1={{ label: 'Nombre des missions', value: workerMissions.length, icon: <Dock className="size-6" /> }}
                    metric_2={{ label: 'Hours Required', value: 5 }}
                    metric_3={{ label: 'Hours Put', value: 8 }}
                    metric_4={{ label: 'Numbers of tasks', value: myTasks.length, icon: <Workflow className="size-6" /> }}
                    // metric_4={{ label: 'Total TVA', value: totalTva }}
                />
            </div>
            <div className="flex flex-col gap-4 p-4 md:flex-row md:justify-between">
                <div>
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg font-semibold">Mes missions</CardTitle>
                            <CardDescription>Vous avez {workerMissions.length} missions en cours</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-8">
                            {workerMissions.map((workerMission: any) => (
                                <MissionCard key={workerMission.id} mission={workerMission.mission} />
                            ))}
                        </CardContent>
                    </Card>
                </div>

                <div>
                    <Card>
                        <CardHeader>
                            <CardTitle className="text-lg font-semibold">Mes tâches</CardTitle>
                            <CardDescription>Vous avez {myTasks.length} tâches en cours</CardDescription>
                        </CardHeader>
                        <CardContent className="space-y-8">
                            {myTasks.map((task: any) => (
                                <TaskCard key={task.id} mission={task.mission} task={task} />
                            ))}
                        </CardContent>
                    </Card>
                </div>
            </div>
        </AppLayout>
    );
}
