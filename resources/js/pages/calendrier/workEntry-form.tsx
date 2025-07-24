import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { useForm } from '@inertiajs/react';
import { toast } from 'sonner';

export default function WorkEntryForm({ mission_task_id, onClose }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        // Define your form data structure here
        mission_task_id: mission_task_id,
        entry_date: '',
        hours_worked: '',
        description: '',
        completed: false,
    });

    function submit(e) {
        e.preventDefault();
        console.log('Submitting work entry:', data);
        post(route('workEntry.save'), {
            onSuccess: () => {
                toast.success('Enregistrement réussi');
                // reset(); // Optional: reset form after submission
                onClose(); // Close the dialog after submission
                // refresh the page after 2 seconds
            },
        });
    }
    return (
        <div>
            <form onSubmit={submit} className="w-full space-y-4">
                <div>
                    <Label htmlFor="entry_date">Date d'entrée</Label>
                    <Input
                        id="entry_date"
                        type="date"
                        value={data.entry_date}
                        onChange={(e) => setData('entry_date', e.target.value)}
                        className={errors.entry_date && '!ring-red-500'}
                    />
                </div>
                <div>
                    <Label htmlFor="hours_worked">Heures travaillées</Label>
                    <Input
                        id="hours_worked"
                        type="number"
                        value={data.hours_worked}
                        onChange={(e) => setData('hours_worked', e.target.value)}
                        className={errors.hours_worked && '!ring-red-500'}
                    />
                </div>
                <div>
                    <Label htmlFor="description">Description</Label>
                    <Input
                        id="description"
                        type="text"
                        value={data.description}
                        onChange={(e) => setData('description', e.target.value)}
                        className={errors.description && '!ring-red-500'}
                    />
                </div>
                <div className="flex items-center space-x-2">
                    <Input
                        id="completed"
                        className="h-4 w-4"
                        type="checkbox"
                        checked={data.completed}
                        onChange={(e) => setData('completed', e.target.checked)}
                    />
                    <Label htmlFor="completed">Marqué comme terminé</Label>
                </div>
                <Button type="submit" disabled={processing} className="w-full">
                    Enregistrer l'entrée de travail
                </Button>
            </form>
        </div>
    );
}
