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
        <h2 class="d-block pt-4">Issues</h2>

        <v-row class="align-center justify-start">
            <v-col cols="3">
                <v-overflow-btn :items="activeProjects" :loading="loading" append-icon="mdi-folder-multiple" editable
                                item-text="name" item-value="id" label="Project" segmented
                                v-model="selectedProject"/>
            </v-col>
        </v-row>

        <v-data-table :headers="issuesHeaders" :items="issues" :items-per-page="10" :loading="loading"
                      @click:row="handleClick" class="elevation-1">
            <template v-slot:item.resolved="{ item }">
                <v-simple-checkbox disabled v-model="item.resolved"></v-simple-checkbox>
            </template>
            <template v-slot:item.seenAt="{ item }">{{ item.seenAt|timeago }}</template>
        </v-data-table>
    </v-container>
</template>

<script>
    import {mapMutations} from 'vuex';

    export default {
        name: "IssuesList",
        data: () => ({
            loading: false,
            activeProjects: [],
            selectedProject: null,
            issuesHeaders: [
                {text: 'Seen At', value: 'seenAt'},
                {text: 'Request Method', value: 'request.method'},
                {text: 'Request URL', value: 'request.url'},
                {text: 'Exception Class', value: 'exception.class'},
                {text: 'Exception Message', value: 'exception.message'},
                {text: 'Resolved', value: 'resolved'},
            ],
            issues: [],
        }),
        created() {
            this.fetchProjectsList();
        },
        watch: {
            selectedProject: function (newProjectId) {
                this.fetchIssuesList(newProjectId);
            },
        },
        methods: {
            fetchProjectsList() {
                this.loading = true;

                this.$store.dispatch('projects/fetchList')
                    .then(response => {
                        this.activeProjects = response.data.filter(project => !project.archived);
                        if (this.activeProjects.length) {
                            this.selectedProject = this.activeProjects[0].id;
                        }
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
            fetchIssuesList(projectId) {
                this.loading = true;

                this.$store.dispatch('issues/fetchList', projectId)
                    .then(response => {
                        this.issues = response.data;
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
            handleClick(issue, row) {
                this.$router.push({name: 'issue-detail', params: {id: issue.id}});
            },
            ...mapMutations({
                setSnackMessage: 'setSnackMessage'
            })
        }
    }
</script>

<style scoped>

</style>
