import { Accordion, AccordionContent, AccordionItem, AccordionTrigger } from '@/components/ui/accordion';
import { Avatar, AvatarFallback } from '@/components/ui/avatar';
import { Badge } from '@/components/ui/badge';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import CommentForm from './comment-form';
import WorkEntryForm from './workEntry-form';

export default function TaskDialog({ open, onClose, task }) {
    return (
        <Dialog open={open} onOpenChange={onClose}>
            {/* <DialogTrigger>Open Dialog</DialogTrigger> */}
            <DialogContent className="max-h-[90vh] overflow-y-auto">
                <DialogHeader>
                    <DialogTitle className="flex items-center gap-2">
                        Détails de la tâche{' '}
                        {task.status === 'En Cours' ? (
                            <Badge className="bg-yellow-500 font-semibold text-white">En cours</Badge>
                        ) : task.status === 'Terminée' ? (
                            <Badge className="bg-green-500 font-semibold text-white">Terminée</Badge>
                        ) : (
                            <Badge className="bg-red-500 font-semibold text-white">Non commencée</Badge>
                        )}{' '}
                    </DialogTitle>
                    <DialogDescription>Voici les détails de la tâche.</DialogDescription>
                </DialogHeader>
                <div>
                    <h3 className="mb-3 text-lg font-medium">
                        {task.name} -{' '}
                        {task.priority === 'élevée' ? (
                            <Badge className="bg-red-500 font-semibold text-white">élevée</Badge>
                        ) : task.priority === 'basse' ? (
                            <Badge className="bg-blue-500 font-semibold text-white">basse</Badge>
                        ) : task.priority === 'normale' ? (
                            <Badge className="bg-yellow-500 font-semibold text-white">normale</Badge>
                        ) : (
                            <span className="font-semibold text-green-500">Low Priority</span>
                        )}
                    </h3>
                    <p>Type: {task.task_type.name}</p>
                    <p>Description : {task.description}</p>
                    {/* <p>Estimated Hours: {task.estimated_hours}</p> */}

                    <div className="mb-4 border-b border-gray-200 pb-2"></div>
                    <h2 className="text-lg font-medium">Entrer des heures de travail</h2>
                    <p className="text-sm text-gray-500">Entrez les heures de travail pour cette tâche.</p>
                    <WorkEntryForm mission_task_id={task.id} onClose={onClose} />

                    {/* <div className="mb-4 border-b border-gray-200 pb-2"></div>
                    <h2 className="text-lg font-medium">Détails de la mission</h2>
                    <h3>Mission: {task.mission?.name}</h3> */}
                    <div className="mb-4 border-b border-gray-200 pb-2"></div>
                    <Accordion type="single" collapsible>
                        <AccordionItem value="item-1">
                            <AccordionTrigger>Historique des heures de travail</AccordionTrigger>
                            <AccordionContent>
                                {/* Here you can map through the work entries related to the task */}
                                {task.work_entries.map((entry) => (
                                    <div key={entry.id} className="border-b border-gray-200 py-2">
                                        <p className="font-semibold">{entry.description}</p>
                                        <p>
                                            {entry.hours_worked} heures le {entry.entry_date}
                                        </p>
                                    </div>
                                ))}
                            </AccordionContent>
                        </AccordionItem>
                        <AccordionItem value="item-2">
                            <AccordionTrigger>Commentaires</AccordionTrigger>

                            <AccordionContent>
                                <CommentForm mission_task_id={task.id} onClose={onClose} />
                                {/* Here you can map through the comments related to the task */}
                                <div className="mt-4 max-h-60 space-y-4 overflow-y-auto rounded-md bg-gray-50 p-4">
                                    {task.comments.map((comment) => (
                                        <div key={comment.id} className="border-b border-gray-200 py-2">
                                            <div className="mb-2 flex items-center gap-2">
                                                <Avatar className="h-9 w-9">
                                                    <AvatarFallback>{comment.author.name.charAt(0)}</AvatarFallback>
                                                </Avatar>
                                                <p className="font-semibold">{comment.author.name}</p>
                                            </div>
                                            <p>{comment.content}</p>
                                        </div>
                                    ))}
                                </div>
                            </AccordionContent>
                        </AccordionItem>
                    </Accordion>
                </div>
            </DialogContent>
        </Dialog>
    );
}
