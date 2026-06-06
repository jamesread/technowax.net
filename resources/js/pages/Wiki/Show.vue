<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

defineProps<{
    page: {
        title: string;
        displayTitle: string;
        content: string;
        canEdit: boolean;
    };
}>();
</script>

<template>
    <Head :title="page.displayTitle" />
    <section>
        <h2>{{ page.displayTitle }}</h2>
        <div v-html="page.content" />
        <p v-if="page.canEdit">
            <Link :href="`/wiki/${page.title}/edit`">Edit</Link>
        </p>
    </section>
</template>
