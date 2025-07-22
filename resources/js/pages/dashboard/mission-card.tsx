import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { format } from 'date-fns';

export function MissionCard({ mission }: { mission: any[] }) {
    return (
        <div className="space-y-8">
            <div key={mission.id} className="flex cursor-pointer items-start rounded-lg p-4 transition-colors hover:bg-muted">
                <Avatar className="h-9 w-9">
                    <AvatarFallback>{mission.name.charAt(0)}</AvatarFallback>
                </Avatar>
                <div className="ml-4 space-y-1">
                    <p className="text-sm leading-none font-medium">{mission.name}</p>
                    <p className="text-mutedForeground text-sm">{mission.description}</p>
                    <p className="text-mutedForeground text-xs font-light">
                        {format(mission.start_date, 'MMM dd, yyyy')} - {format(mission.end_date, 'MMM dd, yyyy')}
                    </p>
                </div>
                {/* <div className="ml-auto self-end">
                    <p className="text-xs text-green-500">{mission.estimated_hours}h</p>
                </div> */}
            </div>
        </div>
    );
}
