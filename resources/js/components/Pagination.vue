<script setup lang="ts">
import { PaginateMeta } from '@/types';
import { Link } from '@inertiajs/vue3';
import { ChevronLeft, ChevronRight, ChevronsLeft, ChevronsRight } from 'lucide-vue-next';
import { PaginationEllipsis } from 'reka-ui';
import { Button } from './ui/button';

defineProps<{
    data: PaginateMeta<any>;
}>();
</script>

<template>
    <div class="flex w-full items-center justify-between gap-2 md:flex-col-reverse lg:flex-row">
        <div class="text-sm">
            Displaying
            <span class="font-semibold">{{ data.from }}</span>
            to
            <span class="font-semibold">{{ data.to }}</span> of
            <span class="font-semibold">{{ data.total }}</span>
        </div>

        <div class="hidden md:block">
            <div class="flex items-center gap-1">
                <!-- First page -->
                <Link :href="data.links[1].url ?? '#'" preserve-scroll>
                    <Button
                        :class="data.prev_page_url == null ? 'cursor-not-allowed' : ''"
                        size="sm"
                        :variant="data.prev_page_url ? 'ghost' : 'outline'"
                        :disabled="data.prev_page_url === null"
                    >
                        <ChevronsLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <!-- End First page -->
                <!-- Previous -->
                <Link :href="data.prev_page_url ?? '#'" preserve-scroll>
                    <Button
                        :class="data.prev_page_url == null ? 'cursor-not-allowed' : ''"
                        size="sm"
                        :variant="data.prev_page_url ? 'ghost' : 'outline'"
                        :disabled="data.prev_page_url === null"
                    >
                        <ChevronLeft class="h-4 w-4" />
                    </Button>
                </Link>
                <!-- End Previous -->
                <!-- Paginatior List -->
                <template v-for="(item, index) in data.links" :key="index">
                    <template v-if="index != 0 && index != data.links.length - 1">
                        <Link :href="item.url" class="text-sm" preserve-scroll v-if="item.url">
                            <Button size="sm" :variant="item.active ? 'secondary' : 'ghost'">
                                {{ item.label }}
                            </Button>
                        </Link>
                        <PaginationEllipsis v-else />
                    </template>
                </template>
                <!-- End Paginatior List -->
                <!-- Next -->
                <Link :href="data.next_page_url ?? '#'" preserve-scroll>
                    <Button
                        :class="data.next_page_url == null ? 'cursor-not-allowed' : ''"
                        size="sm"
                        :variant="data.next_page_url ? 'ghost' : 'outline'"
                        :disabled="data.next_page_url === null"
                    >
                        <ChevronRight class="h-4 w-4" />
                    </Button>
                </Link>
                <!-- End Next -->
                <!-- Last page -->
                <Link :href="data.links[data.links.length - 2].url ?? '#'" preserve-scroll>
                    <Button
                        :class="(data.next_page_url ?? '#') ? 'cursor-not-allowed' : ''"
                        size="sm"
                        :variant="(data.next_page_url ?? '#') ? 'ghost' : 'outline'"
                        :disabled="data.next_page_url ?? '#'"
                    >
                        <ChevronsRight class="h-4 w-4" />
                    </Button>
                </Link>
                <!-- End Last page -->
            </div>
        </div>
        <div class="md:hidden">
            <div class="flex items-center gap-1">
                <Link :href="data.prev_page_url ?? '#'" preserve-scroll>
                    <Button
                        :class="data.prev_page_url == null ? 'cursor-not-allowed' : ''"
                        size="sm"
                        :variant="data.prev_page_url ? 'ghost' : 'outline'"
                        :disabled="data.prev_page_url === null"
                    >
                        Previous
                    </Button>
                </Link>
                <Link :href="data.next_page_url ?? '#'" preserve-scroll>
                    <Button
                        :class="data.next_page_url == null ? 'cursor-not-allowed' : ''"
                        size="sm"
                        :variant="data.next_page_url ? 'ghost' : 'outline'"
                        :disabled="data.next_page_url === null"
                    >
                        Next
                    </Button>
                </Link>
            </div>
        </div>
    </div>
</template>
