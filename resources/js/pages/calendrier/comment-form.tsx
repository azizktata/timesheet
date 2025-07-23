import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/react';
import { toast } from 'sonner';

export default function CommentForm({ mission_task_id, onClose }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        // Define your form data structure here
        mission_task_id: mission_task_id,
        content: '',
    });

    function submit(e) {
        e.preventDefault();
        post(route('comment.save'), {
            onSuccess: () => {
                toast.success('Commentaire ajouté avec succès');
                reset();
                onClose();
            },
        });
    }
    return (
        <div>
            <form onSubmit={submit} className="w-full space-y-4">
                <div>
                    <Textarea
                        id="content"
                        value={data.content}
                        onChange={(e) => setData('content', e.target.value)}
                        className={errors.content && '!ring-red-500'}
                        placeholder="Ajouter un commentaire..."
                    />
                </div>
                <Button type="submit" disabled={processing} className="w-full bg-blue-500 text-white">
                    Ajouter le commentaire
                </Button>
            </form>
        </div>
    );
}
