<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });
</script>

<template>
    <Head title="Tools" />
    <section>
        <h2>Utilities</h2>
        <h3>Self-hosting</h3>
        <ul>
            <li><Link href="/tools/dns-lookup">DNS lookup</Link> — inspect records for domains you operate or depend on</li>
        </ul>
        <p>See <Link href="/services">Services</Link> for dynamic DNS, document repos, and account features.</p>

        <h3>Development / misc</h3>
        <p class="subtle">Legacy toys kept during development; not core to the self-hosting mission.</p>
        <ul>
            <li><Link href="/tools/indenter">Indenter</Link></li>
            <li><Link href="/tools/team-maker">Team maker</Link></li>
        </ul>
    </section>
</template>
