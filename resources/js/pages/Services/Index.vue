<script setup lang="ts">
import { Head, Link, usePage } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

const page = usePage();
</script>

<template>
    <Head title="Services" />
    <section>
        <h2>Community</h2>
        <p>
            Most of the technowax community is on
            <a v-if="page.props.site.discordInviteUrl" :href="page.props.site.discordInviteUrl" class="external">Discord</a>
            <template v-else>Discord</template>
            right now. This website is for self-hosting utilities, documentation, and account services — not forums or chat.
        </p>
    </section>

    <section>
        <h2>Services for self-hosters</h2>
        <p>Practical tools for people who run their own software and infrastructure. No account required for lookups; account required for personal services.</p>
        <p>See also <Link href="/projects">featured open source projects</Link> curated for this community.</p>

        <dl>
            <dt><Link href="/tools/dns-lookup">DNS lookup</Link></dt>
            <dd>Query A, AAAA, MX, CNAME, and other records for a hostname. Useful when debugging mail, reverse proxies, and split-horizon DNS.</dd>

            <dt><Link href="/markdown">Document repos</Link></dt>
            <dd>Markdown files served from this site — intended for homelab notes, stack documentation, and config references you want to share or browse in one place.</dd>

            <dt><Link href="/dyndns/updates">Dynamic DNS</Link></dt>
            <dd>
                <template v-if="page.props.auth.user">
                    Record your current public IPv4 address from routers, scripts, or ddclient-compatible clients.
                </template>
                <template v-else>
                    <Link href="/login">Log in</Link> or <Link href="/register">register</Link> to receive a personal update endpoint and view your update history.
                </template>
            </dd>
        </dl>
    </section>

    <section>
        <h2>Running your own stack</h2>
        <p>This instance is a development deployment. Production content will focus on open source software, self-hosting, and modern infrastructure without hype or vendor funnels.</p>
        <p>If you are evaluating the site: join Discord for discussion, create an account here for dynamic DNS, and watch the document repos for published guides.</p>
    </section>
</template>
