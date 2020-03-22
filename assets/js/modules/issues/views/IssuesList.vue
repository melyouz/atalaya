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

        <v-data-table :headers="issuesHeaders" :items="issues" :items-per-page="10" class="elevation-1">
            <!--<template #item.full_request="{ item }">{{ item.request.method }} {{ item.request.url }}</template>-->
            <template v-slot:item.resolved="{ item }">
                <v-icon>
                    {{ item.resolved ? "mdi-checkbox-marked" : "mdi-checkbox-blank-outline" }}
                </v-icon>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>
    export default {
        name: "IssuesList",
        data: () => ({
            loading: false,
            activeProjects: [],
            selectedProject: null,
            issuesHeaders: [
                {text: 'Id', value: 'id'},
                {text: 'Request Method', value: 'request.method'},
                {text: 'Request URL', value: 'request.url'},
                {text: 'Exception Class', value: 'exception.class'},
                {text: 'Exception Message', value: 'exception.message'},
                {text: 'Resolved', value: 'resolved'},
            ],
            /*{
                text: string
                value: string
                align?: 'start' | 'center' | 'end'
                sortable?: boolean
                filterable?: boolean
                divider?: boolean
                class?: string | string[]
                width?: string | number
                filter?: (value: any, search: string, item: any) => boolean
                sort?: (a: any, b: any) => number

            }*/
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
        }
    }
</script>

<style scoped>

</style>
