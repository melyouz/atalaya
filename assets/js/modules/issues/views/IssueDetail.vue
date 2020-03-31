<!--
  -
  - @copyright 2020 Mohammadi El Youzghi. All rights reserved
  - @author    Mohammadi El Youzghi (mo.elyouzghi@gmail.com)
  -
  - @link      https://github.com/ayrad
  -
  - @licence   GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
  -
  -->

<template>
    <v-container>
        <div v-if="issue">
            <h2 class="d-block pt-4">{{ issue.exception.class }}</h2>

            <div>
                <v-icon class="pr-1 pb-1" color="red" small>mdi-checkbox-blank-circle</v-icon>
                {{ issue.exception.message }}
            </div>
            <div>
                <v-icon class="pr-1 pb-1" small>mdi-calendar</v-icon>
                {{ issue.seenAt|datetime }} ({{ issue.seenAt|timeago }})
            </div>

            <div class="mt-4">
                <v-btn v-if="!issue.resolved" @click="resolve()" :loading="loading" depressed outlined color="primary" small>
                    <v-icon small class="mr-1">mdi-check-outline</v-icon> Resolve
                </v-btn>
                <v-btn v-if="issue.resolved" @click="unresolve()" :loading="loading" depressed color="primary" small>
                    <v-icon small class="mr-1">mdi-check-bold</v-icon> Resolved
                </v-btn>
            </div>

            <h3 class="d-block mt-4">Request</h3>
            <div class="mt-2">
                <v-chip class="font-weight-bold" color="primary" disabled label>{{ issue.request.method }}</v-chip>
                {{ issue.request.url }}
            </div>
            <div class="ml-4 mt-4">
                <h4>Headers</h4>
                <pre><template v-for="(value, key, index) in issue.request.headers">{{ key }}: {{ value }}
</template></pre>
            </div>

            <h3 class="d-block pt-4">Tags</h3>
            <div class="mt-2">
                <v-btn-toggle class="ma-1" v-for="(tag, i) in issue.tags" :key="i">
                    <v-btn class="disable-events" color="primary" outlined small>{{ tag.name }}</v-btn>
                    <v-btn class="disable-events" depressed outlined small>{{ tag.value }}</v-btn>
                </v-btn-toggle>
            </div>

            <h3 class="d-block pt-4">Exception</h3>
            <div class="mt-2">
                <div>{{ issue.exception.class }}</div>
                <div>{{ issue.exception.message }}</div>
                <!-- @todo: Add exception trace, file, line, code excerpt, ...-->
            </div>
        </div>
    </v-container>
</template>

<script>
    import {mapMutations} from 'vuex';

    export default {
        name: "IssueDetail",
        data: () => ({
            loading: false,
            issue: null,
        }),
        created() {
            const id = this.$route.params.id;
            this.fetchIssue(id);
        },
        methods: {
            fetchIssue(id) {
                this.loading = true;

                this.$store.dispatch('issues/fetch', id)
                    .then(response => {
                        this.issue = response.data;
                    })
                    .catch(error => {
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },
            resolve() {
                this.loading = true;
                this.$store.dispatch('issues/resolve', this.issue.id)
                    .then(response => {
                        this.issue.resolved = true;
                    })
                    .catch(error => {
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
                    })
                    .finally(() => {
                            this.loading = false;
                    });
            },
            unresolve() {
                this.loading = true;
                this.$store.dispatch('issues/unresolve', this.issue.id)
                    .then(response => {
                        this.issue.resolved = false;
                    })
                    .catch(error => {
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
                    })
                    .finally(() => {
                        this.loading = false;
                    });
            },
            ...mapMutations({
                setSnackMessage: 'setSnackMessage'
            })
        }
    }
</script>

<style scoped>
    .disable-events {
        pointer-events: none
    }
</style>
