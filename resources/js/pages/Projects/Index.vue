<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type Project = {
    name: string;
    description: string | null;
    homepage_url: string | null;
    github_url: string | null;
    docs_url: string | null;
};

defineProps<{
    projects: Project[];
}>();
</script>

<template>
    <Head title="Featured projects" />
    <section>
        <h2>Featured projects</h2>
        <p>
            Open source projects curated from
            <a href="https://jread.com/projects" class="external">jread.com/projects</a>
            — practical software for self-hosters and homelab operators.
        </p>

        <p v-if="projects.length === 0">No featured projects have been imported yet.</p>

        <article v-for="project in projects" :key="project.name" class="featured-project">
            <h3>
                <a v-if="project.homepage_url" :href="project.homepage_url" class="external">{{ project.name }}</a>
                <template v-else>{{ project.name }}</template>
            </h3>
            <p v-if="project.description">{{ project.description }}</p>
            <ul>
                <li v-if="project.github_url">
                    <a :href="project.github_url" class="external">GitHub</a>
                </li>
                <li v-if="project.docs_url">
                    <a :href="project.docs_url" class="external">Documentation</a>
                </li>
                <li v-if="project.homepage_url">
                    <a :href="project.homepage_url" class="external">Project page</a>
                </li>
            </ul>
        </article>
    </section>
</template>
