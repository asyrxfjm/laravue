import { useForm } from '@inertiajs/vue3';
import { toTypedSchema } from '@vee-validate/zod';
import * as z from 'zod';

export const useUserAction = () => {
    const _update = () => {
        const schema = toTypedSchema(
            z.object({
                name: z.string().min(2).max(50),
                email: z.string().email().min(6).max(50),
                roles: z.array(z.string()),
            }),
        );

        const form = useForm<{
            name: string;
            email: string;
            roles: string[];
        }>({
            name: '',
            email: '',
            roles: [],
        });

        const set = (body: IUserAction) => {
            form.name = body.name;
            form.email = body.email;
            form.roles = body.roles;
        };

        return {
            schema,
            form,
            set,
        };
    };

    return {
        _update,
    };
};

export interface IUserAction {
    name: string;
    email: string;
    roles: string[];
}
