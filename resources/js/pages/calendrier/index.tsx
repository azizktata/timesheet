import AppLayout from '@/layouts/app-layout';
import { type BreadcrumbItem } from '@/types';
import dayGridPlugin from '@fullcalendar/daygrid';
import FullCalendar from '@fullcalendar/react';
import { Head, usePage } from '@inertiajs/react';
// import interactionPlugin from '@fullcalendar/interaction';
import React from 'react';
import '../../../css/planification.css';
import TaskDialog from './task-dialog';
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Calendrier',
        href: '/calendrier',
    },
];

export default function Calendrier() {
    const { workerMissions, myTasks } = usePage<PageProps>().props;
    // console.log('workerMissions', workerMissions);
    console.log('myTasks', myTasks);
    const renderEventContent = (eventInfo) => {
        const { event, el } = eventInfo;

        // Remove time rendering (if present)
        const timeEl = el.querySelector('.fc-event-time');
        if (timeEl) timeEl.remove();

        const customDiv = document.createElement('div');
        customDiv.className = 'custom-number';
        customDiv.innerText = event.extendedProps?.status;
        customDiv.style.color = event.borderColor;
        customDiv.style.borderLeft = `4px solid ${event.borderColor}`;
        el.appendChild(customDiv);

        el.style.backgroundColor = event.backgroundColor || event.color;
        el.style.borderTop = `4px solid ${event.borderColor}`;

        if (event.extendedProps?.planning?.isVerif === 'Oui') {
            const icon = document.createElement('div');
            icon.className = 'verif-icon';

            icon.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-check-icon lucide-circle-check"><circle cx="12" cy="12" r="10" data--h-bstatus="0OBSERVED"/><path d="m9 12 2 2 4-4" data--h-bstatus="0OBSERVED"/></svg>`;
            el.appendChild(icon);
        }
    };

    const [dialogOpen, setDialogOpen] = React.useState(false);
    const [dialogData, setDialogData] = React.useState(null);
    // open dialog on event click
    const handleEventClick = (info) => {
        // console.log('Event clicked:', info.event);
        setDialogData(info.event.extendedProps.task);
        setDialogOpen(true);
    };
    return (
        <AppLayout breadcrumbs={breadcrumbs}>
            <Head title="Calendrier" />
            <div id="calendar" className="p-4">
                <FullCalendar
                    plugins={[dayGridPlugin]}
                    initialView="dayGridMonth"
                    locale="fr"
                    events={myTasks.map((task: any) => ({
                        id: task.id,
                        title: task.name,
                        start: task.due_date,
                        end: task.due_date,
                        description: task.description,
                        // allDay: true,
                        // display: 'background',
                        color: task.priority === 'élevée' ? '#ff8b8bff' : task.priority === 'basse' ? '#9494ffff' : '#ffff8bff',
                        borderColor: task.priority === 'élevée' ? '#ff0000' : task.priority === 'basse' ? '#0000ff' : '#00ff00',
                        extendedProps: {
                            status: task.status,
                            hours: task.estimated_hours,
                            mission: task.mission,
                            task: task,
                        },
                    }))}
                    headerToolbar={{
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth, timeGridWeek',
                    }}
                    eventDidMount={renderEventContent}
                    eventClick={handleEventClick}
                    // eventOverlap={(stillEvent, movingEvent) => stillEvent.allDay && movingEvent!.allDay}
                />
                {dialogData && <TaskDialog open={dialogOpen} onClose={() => setDialogOpen(false)} task={dialogData} />}
            </div>
        </AppLayout>
    );
}
