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
    <section class="wiki-page">
        <div class="page-header">
            <h2>{{ page.displayTitle }}</h2>
            <nav
                v-if="page.canEdit"
                class="page-actions"
                aria-label="Page actions"
            >
                <Link :href="`/wiki/${page.title}/edit`">Edit</Link>
            </nav>
        </div>
        <div v-html="page.content" />
    </section>
</template>
