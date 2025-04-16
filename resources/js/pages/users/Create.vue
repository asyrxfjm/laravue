<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { useUserAction } from '@/composables/useUserAction';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useForm } from 'vee-validate';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const { schema, form } = useUserAction().storeUser();

const { handleSubmit, setFieldError } = useForm({
    validationSchema: schema,
});

const onSubmit = handleSubmit((values) => {
    form(values, setFieldError);
});
</script>

<template>
    <Head title="Create - User" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <form @submit="onSubmit">
            <Card class="mx-auto w-full max-w-3xl">
                <CardHeader>
                    <CardTitle>Create User</CardTitle>
                    <CardDescription>Fill out the form below to create a new user.</CardDescription>
                </CardHeader>
                <CardContent class="space-y-6">
                    <FormField v-slot="{ componentField }" name="username">
                        <FormItem>
                            <FormLabel>Username</FormLabel>
                            <FormControl>
                                <Input placeholder="john@doe.com" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="name">
                        <FormItem>
                            <FormLabel>Full Name</FormLabel>
                            <FormControl>
                                <Input placeholder="John Doe" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="email">
                        <FormItem>
                            <FormLabel>Email</FormLabel>
                            <FormControl>
                                <Input type="email" placeholder="shadcn" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                    <FormField v-slot="{ componentField }" name="password">
                        <FormItem>
                            <FormLabel>Password</FormLabel>
                            <FormControl>
                                <Input type="password" placeholder="shadcn" v-bind="componentField" />
                            </FormControl>
                            <FormMessage />
                        </FormItem>
                    </FormField>
                </CardContent>
                <CardFooter>
                    <Button type="submit">Save</Button>
                </CardFooter>
            </Card>
        </form>
    </AppLayout>
</template>
