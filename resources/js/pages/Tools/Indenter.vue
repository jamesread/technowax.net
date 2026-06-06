<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

defineProps<{
    content: string;
    lineWidth: number;
    prefix: string;
    removeExtraNewlines: boolean;
    output: string | null;
}>();
</script>

<template>
    <Head title="Indenter" />
    <section>
        <h2>Indenter</h2>
        <Form action="/tools/indenter" method="post" v-slot="{ processing }">
            <p>
                <label for="content">Content</label><br />
                <textarea id="content" name="content" rows="12" cols="80">{{ content }}</textarea>
            </p>
            <p>
                <label for="line_width">Line width</label><br />
                <input id="line_width" name="line_width" type="number" :value="lineWidth" min="1" max="500" />
            </p>
            <p>
                <label for="prefix">Prefix</label><br />
                <input id="prefix" name="prefix" type="text" :value="prefix" maxlength="10" />
            </p>
            <p>
                <label>
                    <input name="remove_extra_newlines" type="checkbox" value="1" :checked="removeExtraNewlines" />
                    Remove extra newlines
                </label>
            </p>
            <p><button type="submit" :disabled="processing">Indent</button></p>
        </Form>
    </section>

    <section v-if="output">
        <h2>Indented content</h2>
        <div v-html="output" />
    </section>
</template>
