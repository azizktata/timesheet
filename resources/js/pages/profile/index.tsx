import { DateRangePicker } from '@/components/date-range';
import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import { Head, router, usePage } from '@inertiajs/react';
import { CheckCircle, Clock, PenBoxIcon } from 'lucide-react';
import { useEffect, useState } from 'react';
import { SectionCards } from './cards-section';
import { ChartPieInteractive } from './pie-chart';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Profile',
        href: '/profile',
    },
];
interface PageProps {
    totalHoursWorked: number;
    tasksCompleted: number;
    hoursEstimated: number;
    hoursVsEstimatedPercentage: number;
    totalTasks: number;
    startDate: string;
    endDate: string;
    workEntries: any[];
    pieData1: { label: string; value: number; fill?: string }[];
    pieData2: { label: string; value: number; fill?: string }[];
}
export default function Index() {
    const { totalHoursWorked, tasksCompleted, hoursEstimated, totalTasks, startDate, endDate, workEntries, pieData1, pieData2 } =
        usePage<PageProps>().props;
    console.log('Page Props:', usePage<PageProps>().props);
    const [dateRange, setDateRange] = useState({
        from: startDate,
        to: endDate,
    });

    // add fill property to pieData1 and pieData2
    const updatedPieData1 = pieData1.map((item, index) => ({
        ...item,
        fill: `#${Math.floor(Math.random() * 16777215).toString(16)}`,
    }));
    const updatedPieData2 = pieData2.map((item, index) => ({
        ...item,
        // fill: `var(--color-${index + 5})`,
        fill: `#${Math.floor(Math.random() * 16777215).toString(16)}`,
    }));
    useEffect(() => {
        const delayDebounceFn = setTimeout(() => {
            router.get(route('profile'), { dateRange }, { preserveState: true, replace: true });
        }, 500); // 500ms debounce

        return () => clearTimeout(delayDebounceFn);
    }, [dateRange]);
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Profile" />
            <div className="space-y-4 p-4">
                <div>
                    {/* <Label htmlFor="dateRange">Filtrer par Date</Label> */}
                    <DateRangePicker date={dateRange} setDate={setDateRange} />
                </div>
                <SectionCards
                    metric_1={{ label: 'Tâches Accomplies', value: tasksCompleted, icon: <CheckCircle className="size-6" /> }}
                    metric_2={{ label: 'Heures Totales Travaillées', value: totalHoursWorked, icon: <Clock className="size-6" /> }}
                    metric_3={{ label: 'Heures Estimées', value: hoursEstimated, icon: <Clock className="size-6" /> }}
                    metric_4={{ label: 'Tâches Restantes', value: totalTasks, icon: <PenBoxIcon className="size-6" /> }}
                />

                <div className="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-2">
                    <ChartPieInteractive pieData={updatedPieData1} startDate={startDate} endDate={endDate} label="Heures Travaillées par Mission" />

                    <ChartPieInteractive
                        pieData={updatedPieData2}
                        startDate={startDate}
                        endDate={endDate}
                        label="Heures Travaillées par Type de Tâche"
                    />
                </div>
            </div>
        </AppLayout>
    );
}
