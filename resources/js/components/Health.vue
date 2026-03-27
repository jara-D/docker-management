<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
    id: number;
    name: string;
    state: string;
}>();

const stateClass = computed(() => {
    switch (props.state) {
        case 'running':
            return 'text-green-500';
        case 'exited':
            return 'text-red-500';
        default:
            return 'text-gray-600';
    }
});
</script>

<template>
    <div class="flex items-center gap-2">
        <span class="text-4xl" :class="stateClass">&#9679;</span>
        <span class="text-center">{{ props.name }}</span>
    </div>
</template>

<style scoped></style>
