<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Users',
        href: route('users.index'),
    },
    {
        title: 'User Details',
        href: '#',
    },
];
</script>

<template>
    <Head title="User Details" />

    <AppLayout :breadcrumbs="breadcrumbs"> </AppLayout>
</template>
