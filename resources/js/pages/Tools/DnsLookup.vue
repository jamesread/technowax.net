<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type RecordType = { label: string; value: number };

defineProps<{
    dnsName: string;
    recordType: number;
    results: Array<Record<string, unknown>>;
    recordTypes: RecordType[];
}>();
</script>

<template>
    <Head title="DNS lookup" />
    <section>
        <h2>DNS Lookup</h2>
        <Form action="/tools/dns-lookup" method="post" v-slot="{ processing }">
            <p>
                <label for="dns_name">DNS Name</label><br />
                <input id="dns_name" name="dns_name" type="text" :value="dnsName" required />
            </p>
            <p>
                <label for="record_type">Record type</label><br />
                <select id="record_type" name="record_type">
                    <option v-for="type in recordTypes" :key="type.value" :value="type.value" :selected="type.value === recordType">
                        {{ type.label }}
                    </option>
                </select>
            </p>
            <p><button type="submit" :disabled="processing">lookup</button></p>
        </Form>
    </section>

    <section v-if="results.length > 0">
        <h3>Results</h3>
        <table>
            <thead>
                <tr>
                    <th v-for="(_, key) in results[0]" :key="String(key)">{{ key }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(row, index) in results" :key="index">
                    <td v-for="(value, key) in row" :key="String(key)">{{ value }}</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>
