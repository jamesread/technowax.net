<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import SiteLayout from '@/layouts/SiteLayout.vue';

defineOptions({ layout: SiteLayout });

defineProps<{
    teamList: string;
    teamCount: number;
    teams: string[][];
}>();
</script>

<template>
    <Head title="Team maker" />
    <section>
        <h2>Make teams</h2>
        <Form action="/tools/team-maker" method="post" v-slot="{ processing }">
            <p>
                <label for="team_list">Member list</label><br />
                <textarea id="team_list" name="team_list" rows="10" cols="40">{{ teamList }}</textarea>
                <br /><small>Separate members names by entering each user on a new line.</small>
            </p>
            <p>
                <label for="team_count">Team count</label><br />
                <input id="team_count" name="team_count" type="number" :value="teamCount" min="2" max="100" />
            </p>
            <p><button type="submit" :disabled="processing">Make teams</button></p>
        </Form>
    </section>

    <section v-if="teams.length > 0">
        <h3>Teams</h3>
        <div v-for="(team, index) in teams" :key="index">
            <h4>Team {{ index + 1 }}</h4>
            <ul>
                <li v-for="member in team" :key="member">{{ member }}</li>
            </ul>
        </div>
    </section>
</template>
