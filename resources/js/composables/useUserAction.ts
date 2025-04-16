import { useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';

export const useUserAction = () => {
    const _update = () => {
        const schema = toTypedSchema(
            z.object({
                name: z.string().min(2).max(50),
                email: z.string().email().min(6).max(50),
            }),
        );

        const form = (body: IUserAction) => {
            return useForm({
                name: body.name,
                email: body.email,
            });
        };

        return {
            schema,
            form,
        };
    };

    return {
        _update,
    };
};

export interface IUserAction {
    name: string;
    email: string;
}
