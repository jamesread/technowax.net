<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

type Update = {
    ident: string | null;
    ip_address: string;
    timestamp: string;
};

defineProps<{
    updates: Update[];
    userId: number;
}>();
</script>

<template>
    <Head title="Dynamic DNS" />
    <section>
        <h2>DynDns</h2>
        <p>This is a list of DynDNS updates. IPV4 only.</p>
        <p>You can update this list by having your DynDns client make a HTTP query with the following syntax:</p>
        <p>
            <tt>http://www.technowax.net/dyndns?update&amp;user=<strong>{{ userId }}</strong>&amp;ident=<strong>yourString</strong></tt>
        </p>
        <dl>
            <dt>user</dt>
            <dd>Your user ID, so that dyn dns updates go to your "account"</dd>
            <dt>ident</dt>
            <dd>An optional string that identifies the update in some way. Example: "homeRouter", or "workRouter".</dd>
        </dl>

        <h3>List of updates</h3>
        <p v-if="updates.length === 0">No updates have ever been received.</p>
        <table v-else>
            <thead>
                <tr>
                    <th>Ident</th>
                    <th>IP Address</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(update, index) in updates" :key="index">
                    <td>
                        <span v-if="!update.ident" class="subtle">N/A</span>
                        <template v-else>{{ update.ident }}</template>
                    </td>
                    <td>{{ update.ip_address }}</td>
                    <td>{{ update.timestamp }}</td>
                </tr>
            </tbody>
        </table>
    </section>
</template>
