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
                <template v-if="issue.exception.code">(code: {{ issue.exception.code }})</template>
                {{ issue.exception.message }}
            </div>
            <div>
                <v-icon class="pr-1 pb-1" small>mdi-calendar</v-icon>
                {{ issue.seenAt|datetime }} ({{ issue.seenAt|timeago }})
            </div>

            <div class="mt-4">
                <v-btn :loading="loading" @click="resolve()" color="primary" depressed outlined small
                       v-if="!issue.resolved">
                    <v-icon class="mr-1" small>mdi-check-outline</v-icon>
                    Resolve
                </v-btn>
                <v-btn :loading="loading" @click="unresolve()" color="primary" depressed small v-if="issue.resolved">
                    <v-icon class="mr-1" small>mdi-check-bold</v-icon>
                    Resolved
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
                <v-btn-toggle :key="i" class="ma-1" v-for="(tag, i) in issue.tags">
                    <v-btn class="disable-events" color="primary" outlined small>{{ tag.name }}</v-btn>
                    <v-btn class="disable-events" depressed outlined small>{{ tag.value }}</v-btn>
                </v-btn-toggle>
            </div>

            <h3 class="d-block pt-4">{{issue.exception.class}}</h3>
            <div>
                <div>
                    <template v-if="issue.exception.code">(code: {{ issue.exception.code }})</template>
                    {{ issue.exception.message }}
                </div>
                <div>
                    <div>
                        <v-icon class="pb-1">mdi-chevron-right</v-icon>
                        in {{ issue.exception.file.path }} (line {{ issue.exception.file.line }})
                    </div>
                    <div class="body-2 overflow-auto">
                        <v-list disabled>
                            <v-list-item-group color="warning">
                                <v-list-item v-for="(line, i) in issue.exception.file.excerpt.lines" :key="i" class="list-item-code" v-bind:class="{'v-item--active v-list-item--active': line.selected}">
                                    <v-list-item-content class="py-1 ma-0 overflow-visible">
                                        <pre>{{ line.line }}. {{ line.content }}</pre>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list-item-group>
                        </v-list>
                    </div>
                </div>
                <!-- @todo: Add exception trace(s) -->
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

    .list-item-code {
        min-height: 20px;
    }
</style>
