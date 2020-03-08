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
        <h2 class="d-block pt-4">Projects</h2>
        <v-row class=" d-flex justify-start pa-2">
            <v-card v-for="project in activeProjects" :key="project.id" class="ma-lg-4 ma-md-2 pa-2" min-width="415px">
                <v-card-title>{{ project.name }}</v-card-title>
                <v-card-subtitle >
                    <a :href="project.url" target="_blank" class="body-2 external-link" style="text-decoration: none;">
                        <v-icon color="secondary" style="text-decoration: none;">mdi-link</v-icon> {{ project.url }}
                    </a>
                </v-card-subtitle>
                <v-card-actions>
                    <v-list-item class="grow">
                        <v-row align="center" justify="end">
                            <v-btn small text @click="editingProject = project" color="primary"><v-icon>mdi-pencil</v-icon></v-btn>
                            <v-btn small text @click="archive(project)" color="red"><v-icon>mdi-archive-arrow-down</v-icon></v-btn>
                        </v-row>
                    </v-list-item>
                </v-card-actions>
            </v-card>
        </v-row>

        <h2 v-if="archivedProjects.length" class="d-block pt-12">Archived projects</h2>
        <v-row v-if="archivedProjects.length" class="d-flex justify-start pa-2">
            <v-card v-for="project in archivedProjects" :key="project.id" class="ma-lg-4 ma-md-2 pa-2" min-width="415px">
                <v-card-title>{{ project.name }}</v-card-title>
                <v-card-subtitle >
                    <a :href="project.url" target="_blank" class="body-2 external-link" style="text-decoration: none;">
                        <v-icon color="secondary" style="text-decoration: none;">mdi-link</v-icon> {{ project.url }}
                    </a>
                </v-card-subtitle>
                <v-card-actions>
                    <v-list-item class="grow">
                        <v-row align="center" justify="end">
                            <v-btn @click="unarchive(project)" text color="primary"><v-icon>mdi-archive-arrow-up</v-icon></v-btn>
                        </v-row>
                    </v-list-item>
                </v-card-actions>
            </v-card>
        </v-row>

        <v-btn color="accent" dark fixed bottom right fab @click="newProjectDialog = !newProjectDialog">
            <v-icon>mdi-plus</v-icon>
        </v-btn>

        <v-dialog v-model="newProjectDialog" width="800px">
            <v-card>
                <v-card-title class="secondary">Create project</v-card-title>
                <v-container>
                        <v-form  @keyup.native.enter="create" ref="newProjectForm" v-model="newProjectFormValid" lazy-validation autocomplete="off" class="pa-2">
                            <v-text-field v-model="newProject.name" :rules="rules.name" required autocorrect="off" autocapitalize="none" placeholder="Name"/>
                            <v-text-field v-model="newProject.url" :rules="rules.url" required autocorrect="off" autocapitalize="none" placeholder="URL"/>
                        </v-form>
                </v-container>
                <v-card-actions>
                    <v-spacer />
                    <v-btn text @click="newProjectDialog = false; $refs.newProjectForm.reset()">Cancel</v-btn>
                    <v-btn color="primary" @click="create" :disabled="!newProjectFormValid || loading" :loading="loading">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-if="editingProject" v-model="editingProject" width="800px">
            <v-card>
                <v-card-title class="secondary">Edit project</v-card-title>
                <v-container>
                    <v-form  @keyup.native.enter="edit" ref="editProjectForm" v-model="editProjectFormValid" lazy-validation autocomplete="off" class="pa-2">
                        <v-text-field v-model="editingProject.name" :rules="rules.name" required autocorrect="off" autocapitalize="none" placeholder="Name"/>
                        <v-text-field v-model="editingProject.url" :rules="rules.url" required autocorrect="off" autocapitalize="none" placeholder="URL"/>
                    </v-form>
                </v-container>
                <v-card-actions>
                    <v-spacer />
                    <v-btn text @click="editingProject = null">Cancel</v-btn>
                    <v-btn color="primary" @click="edit" :disabled="!editProjectFormValid || loading" :loading="loading">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    export default {
        name: "ProjectsList",
        data: () => ({
            loading: false,
            newProjectDialog: false,
            newProject: {
                name: '',
                url: '',
            },
            newProjectFormValid: false,
            rules: {
                name: [
                    v => !!v || 'Name is required',
                ],
                url: [
                    v => !!v || 'URL is required',
                    v => /^(?:(?:https?):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(v) || 'Invalid URL',
                ],
            },
            editingProject: null,
            editProjectFormValid: false,
            activeProjects: [],
            archivedProjects: [],
        }),
        created() {
            this.list();
        },
        methods: {
            list() {
                this.$store.dispatch('projects/fetchList')
                    .then(response => {
                        const projects = response.data;
                        this.activeProjects = projects.filter(project => !project.archived);
                        this.archivedProjects = projects.filter(project => project.archived);
                    })
                    .catch(error => {
                        this.setSnackMessage({message: "Unexpected error occurred. Please, try again.", color: "error"});
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },
            create() {
                if (!this.$refs.newProjectForm.validate()) return;
                this.loading = true;
                this.$store.dispatch('projects/create', this.newProject)
                    .then(response => {
                        this.$refs.newProjectForm.reset();
                        this.newProjectDialog = false;
                        this.list();
                    })
                    .catch(error => {
                        this.setSnackMessage({message: "Unexpected error occurred. Please, try again.", color: "error"});
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },
            edit() {
                if (!this.$refs.editProjectForm.validate()) return;
                this.loading = true;
                this.$store.dispatch('projects/edit', this.editingProject)
                    .then(response => {
                        this.editingProject = null;
                        console.log('Editing project should have gone', this.editingProject);
                        this.list();
                    })
                    .catch(error => {
                        this.setSnackMessage({message: "Unexpected error occurred. Please, try again.", color: "error"});
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },
            archive(project) {
                this.$store.dispatch('projects/archive', project.id)
                    .then(response => {
                        this.list();
                    }).catch(error => {
                        this.setSnackMessage({message: "Unexpected error occurred. Please, try again.", color: "error"});
                    });
            },
            unarchive(project) {
                this.$store.dispatch('projects/unarchive', project.id)
                    .then(response => {
                        this.list();
                    }).catch(error => {
                        this.setSnackMessage({message: "Unexpected error occurred. Please, try again.", color: "error"});
                    });
            },
        }
    }
</script>

<style scoped>
    .external-link {
        color: #607d8b;
    }
</style>
