<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

defineProps<{
    title: string;
    createUrl: string;
}>();
</script>

<template>
    <Head title="Wiki page not found" />
    <section>
        <h2>Not found</h2>
        <p>
            Wiki page not found.
            <Link :href="createUrl">Create?</Link>
        </p>
    </section>
</template>
