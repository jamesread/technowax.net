<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type Row = {
    index: number;
    markup: string;
    entity: string;
};

defineProps<{
    rows: Row[];
}>();
</script>

<template>
    <Head title="HTML entities" />
    <section>
        <h2>List of html entities</h2>
        <table>
            <thead>
                <tr>
                    <th>Ordinal/Index</th>
                    <th>HTML Markup</th>
                    <th>Rendered Entity</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.index">
                    <td>{{ row.index }}</td>
                    <td v-html="row.markup" />
                    <td v-html="row.entity" />
                </tr>
            </tbody>
        </table>
    </section>
</template>
