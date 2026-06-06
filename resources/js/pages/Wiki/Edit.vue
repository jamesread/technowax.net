<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

defineProps<{
    page: {
        title: string;
        alt_title: string | null;
        content: string | null;
    };
}>();
</script>

<template>
    <Head :title="`Edit ${page.title}`" />
    <section>
        <h2>Edit Wiki Page</h2>
        <Form :action="`/wiki/${page.title}/edit`" method="post" v-slot="{ errors, processing }">
            <p>
                <label for="alt_title">Alt title</label><br />
                <input id="alt_title" name="alt_title" type="text" maxlength="64" :value="page.alt_title ?? ''" />
                <span v-if="errors.alt_title">{{ errors.alt_title }}</span>
            </p>
            <p>
                <label for="content">Content</label><br />
                <textarea id="content" name="content" rows="20" cols="80">{{ page.content ?? '' }}</textarea>
                <span v-if="errors.content">{{ errors.content }}</span>
            </p>
            <p>
                <button type="submit" :disabled="processing">Save</button>
            </p>
        </Form>
    </section>
</template>
