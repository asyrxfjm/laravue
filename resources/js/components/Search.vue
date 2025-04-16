<script setup lang="ts">
import { Input } from '@/components/ui/input';
import { CircleX, Search } from 'lucide-vue-next';
import { computed } from 'vue';

// Props for customization
const props = withDefaults(
    defineProps<{
        modelValue: string;
        placeholder?: string;
    }>(),
    {
        modelValue: '',
        placeholder: 'Search...',
    },
);

// Emits to update parent component
const emit = defineEmits(['update:modelValue']);

// Local reactive variable
const search = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value),
});

// Clear function
const clearSearch = () => {
    search.value = '';
};
</script>

<template>
    <div class="relative w-full max-w-[175px]">
        <!-- Search Input -->
        <Input type="text" :placeholder="placeholder" v-model="search" class="px-8" />

        <!-- Search Icon (Left) -->
        <span class="absolute inset-y-0 start-0 flex items-center px-2">
            <Search class="text-muted-foreground size-4" />
        </span>

        <!-- Clear Icon (Right) -->
        <span v-if="search" @click="clearSearch" class="absolute inset-y-0 end-0 flex cursor-pointer items-center px-2">
            <CircleX class="text-muted-foreground size-4 transition hover:text-red-500" />
        </span>
    </div>
</template>
