<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type Entry = {
    name: string;
    type: 'file' | 'directory';
    mime: string | null;
};

type Breadcrumb = {
    name: string;
    path: string;
};

defineProps<{
    path: string;
    file: string;
    entries: Entry[];
    breadcrumbs: Breadcrumb[];
    content: string | null;
}>();
</script>

<template>
    <Head title="Document repos" />
    <section>
        <h2 v-if="path === ''">Repo browser</h2>
        <h2 v-else>
            <Link href="/markdown">Repos</Link> &raquo;
            <template v-for="(crumb, index) in breadcrumbs" :key="crumb.path">
                <template v-if="index === breadcrumbs.length - 1"> {{ crumb.name }}</template>
                <template v-else>
                    <Link :href="`/markdown?path=${crumb.path}/`">{{ crumb.name }}</Link> &raquo;
                </template>
            </template>
            <template v-if="file"> {{ file }}</template>
        </h2>

        <p v-if="entries.length === 0 && path === ''">
            No document repositories are published yet. This area is intended for homelab guides, stack write-ups, and config notes.
        </p>
        <p v-else-if="entries.length === 0">This folder is empty.</p>

        <ul v-else class="no-bullets">
            <li v-for="entry in entries" :key="entry.name">
                <div class="list-icon">{{ entry.type === 'directory' ? '&#128193;' : '&#128441;' }}</div>
                <Link
                    v-if="entry.type === 'directory'"
                    :href="`/markdown?path=${path ? path + '/' : ''}${entry.name}/`"
                >
                    {{ entry.name }}
                </Link>
                <Link
                    v-else-if="entry.mime === 'text/plain'"
                    :href="`/markdown?path=${path}&file=${entry.name}`"
                >
                    {{ entry.name }}
                </Link>
                <span v-else>{{ entry.name }} (mimetype not supported)</span>
            </li>
        </ul>
    </section>

    <section v-if="content">
        <div v-html="content" />
    </section>
</template>
