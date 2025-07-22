import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { format } from 'date-fns';

export function TaskCard({ mission, task }: { mission: any; task: any }) {
    return (
        <div className="space-y-8">
            <div key={task.id} className="flex cursor-pointer items-start rounded-lg p-4 transition-colors hover:bg-muted">
                <Avatar className="h-9 w-9">
                    <AvatarFallback>{mission.name.charAt(0)}</AvatarFallback>
                </Avatar>
                <div className="ml-4 space-y-1">
                    <p className="text-sm leading-none font-medium">{task.name} </p>
                    <p className="text-mutedForeground text-sm">{task.description}</p>
                    <p className="text-mutedForeground text-xs font-light">
                        {format(task.due_date, 'MMM dd, yyyy')} / {task.estimated_hours}h
                    </p>
                </div>
                <div className="ml-auto">
                    {task.priority === 'élevée' ? (
                        <Badge className="bg-red-500 font-semibold text-white">élevée</Badge>
                    ) : task.priority === 'basse' ? (
                        <Badge className="bg-blue-500 font-semibold text-white">basse</Badge>
                    ) : task.priority === 'normale' ? (
                        <Badge className="bg-yellow-500 font-semibold text-white">normale</Badge>
                    ) : (
                        <span className="font-semibold text-green-500">Low Priority</span>
                    )}
                </div>
            </div>
        </div>
    );
}
