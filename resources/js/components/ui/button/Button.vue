<script setup lang="ts">
import { cn } from '@/lib/utils';
import { Loader } from 'lucide-vue-next';
import { Primitive, type PrimitiveProps } from 'reka-ui';
import type { HTMLAttributes } from 'vue';
import { type ButtonVariants, buttonVariants } from '.';

interface Props extends PrimitiveProps {
    variant?: ButtonVariants['variant'];
    size?: ButtonVariants['size'];
    class?: HTMLAttributes['class'];
    loading?: boolean;
}

const props = withDefaults(defineProps<Props>(), {
    as: 'button',
});
</script>

<template>
    <Primitive data-slot="button" :as="as" :as-child="asChild" :class="cn(buttonVariants({ variant, size }), props.class)" :disabled="loading">
        <Loader v-if="loading" class="mr-2 animate-spin" />
        <slot />
    </Primitive>
</template>
