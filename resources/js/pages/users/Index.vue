<script setup lang="ts">
import Pagination from '@/components/Pagination.vue';
import Search from '@/components/Search.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardFooter, CardHeader } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuLabel,
    DropdownMenuSeparator,
    DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { useUserAction } from '@/composables/useUserAction';
import AppLayout from '@/layouts/AppLayout.vue';
import { dateFormatter } from '@/lib/utils';
import { BreadcrumbItem, PaginateMeta } from '@/types';
import { Head, Link, router } from '@inertiajs/vue3';
import { useDebounceFn } from '@vueuse/core';
import { Ellipsis, Pencil, Trash, User } from 'lucide-vue-next';
import { useForm } from 'vee-validate';
import { ref, watch } from 'vue';
import { toast } from 'vue-sonner';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: '#',
    },
];

const props = withDefaults(
    defineProps<{
        users: PaginateMeta<App.Http.DTOs.UserData>;
        filters: {
            name: string;
            email: string;
        };
    }>(),
    {
        filters: () => ({
            name: '',
            email: '',
        }),
    },
);

const name = ref(props.filters.name);
const email = ref(props.filters.email);
const triggerSearch = useDebounceFn(() => {
    router.get(
        route('users.index'),
        {
            name: name.value,
            email: email.value,
        },
        {
            preserveState: true,
            replace: true,
        },
    );
}, 500);

watch([name, email], () => triggerSearch());

const selectedUser = ref({} as App.Http.DTOs.UserData);
const openUpdateModal = ref(false);
const openDeleteModal = ref(false);

const action = useUserAction();
const updateAction = action._update();

const form = useForm({
    validationSchema: updateAction.schema,
});
const selectUser = (user: App.Http.DTOs.UserData, type: 'delete' | 'update') => {
    selectedUser.value = user;
    if (type === 'delete') openDeleteModal.value = true;
    else openUpdateModal.value = true;

    form.setValues({
        name: user.name,
        email: user.email,
    });
};

type FormFields = {
    name: string;
    email: string;
};

const onSubmitUpdateForm = form.handleSubmit((values) => {
    updateAction.form(values).put(
        route('users.update', {
            user: selectedUser.value.id,
        }),
        {
            onError: (errors) => {
                for (const [key, value] of Object.entries(errors)) {
                    const fieldKey = key as keyof FormFields;
                    form.setFieldError(fieldKey, value);
                    toast.error(key, { description: value as string });
                }
            },
            onSuccess: () => {
                toast.success('User updated successfully.');
                openUpdateModal.value = false;
            },
        },
    );
});

const onSubmitDeleteForm = () => {
    router.delete(
        route('users.destroy', {
            user: selectedUser.value.id,
        }),
        {
            onError: (error) => {
                toast.error('Error', { description: error.message });
            },
            onSuccess: () => {
                toast.success('User deleted successfully.');
                openDeleteModal.value = false;
            },
        },
    );
};
</script>

<template>
    <Head title="Users" />
    <AppLayout :breadcrumbs="breadcrumbs">
        <Card>
            <CardHeader>
                <div class="flex flex-col items-center gap-2 sm:flex-row">
                    <Search v-model="name" placeholder="Search by Name" />
                    <Search v-model="email" placeholder="Search by Email" />
                </div>
            </CardHeader>
            <CardContent>
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Name</TableHead>
                            <TableHead>Email</TableHead>
                            <TableHead>Created At</TableHead>
                            <TableHead class="w-0 text-right">Action</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="user in users.data" :key="user.id">
                            <TableCell>{{ user.name }}</TableCell>
                            <TableCell>{{ user.email }}</TableCell>
                            <TableCell>{{ dateFormatter(user.created_at) }}</TableCell>
                            <TableCell class="text-right">
                                <DropdownMenu>
                                    <DropdownMenuTrigger>
                                        <Button variant="ghost" size="icon">
                                            <Ellipsis class="size-4" />
                                        </Button>
                                    </DropdownMenuTrigger>
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuLabel>Actions</DropdownMenuLabel>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem as-child>
                                            <Link
                                                :href="
                                                    route('users.show', {
                                                        user: user.id,
                                                    })
                                                "
                                            >
                                                <User class="size-4" /> Details
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            @select="
                                                (e) => {
                                                    e.preventDefault();
                                                    selectUser(user, 'update');
                                                }
                                            "
                                        >
                                            <Pencil class="size-4" /> Edit
                                        </DropdownMenuItem>
                                        <DropdownMenuItem
                                            @select="
                                                (e) => {
                                                    e.preventDefault();
                                                    selectUser(user, 'delete');
                                                }
                                            "
                                        >
                                            <Trash class="size-4" /> Delete
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </CardContent>
            <CardFooter>
                <Pagination :data="users" />
            </CardFooter>
        </Card>

        <Dialog :open="openUpdateModal">
            <DialogContent hideCloseButton>
                <DialogHeader>
                    <DialogTitle>Edit {{ selectedUser.name }}</DialogTitle>
                    <DialogDescription> Make changes to the account here. Click save when you're done. </DialogDescription>
                </DialogHeader>
                <div class="space-y-4">
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem>
                            <FormLabel>Name</FormLabel>
                            <FormControl>
                                <Input placeholder="johndoe" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input type="email" placeholder="johndoe@gmail.com" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </div>
                <DialogFooter>
                    <Button type="button" variant="outline" @click="openUpdateModal = false">Cancel</Button>
                    <Button @click="onSubmitUpdateForm">Save</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>

        <Dialog :open="openDeleteModal">
            <DialogContent hideCloseButton>
                <DialogHeader>
                    <DialogTitle>Are you sure to delete this account?</DialogTitle>
                    <DialogDescription>Make changes to the account here. Click save when you're done.</DialogDescription>
                </DialogHeader>
                <div class="space-y-4">
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem>
                            <FormLabel>Name</FormLabel>
                            <FormControl>
                                <Input placeholder="johndoe" v-bind="componentField" disabled />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input type="email" placeholder="johndoe@gmail.com" v-bind="componentField" disabled />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </div>
                <DialogFooter>
                    <Button type="button" variant="outline" @click="openDeleteModal = false">Cancel</Button>
                    <Button @click="onSubmitDeleteForm">Save</Button>
                </DialogFooter>
            </DialogContent>
        </Dialog>
    </AppLayout>
</template>
