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
        <h2 class="d-block pt-4">Projects
            <v-btn @click="newProjectDialog = !newProjectDialog" depressed>Add new</v-btn>
        </h2>

        <v-row v-if="activeProjects.length">
            <v-col :key="project.id" cols="12" sm="6" xl="4" v-for="project in activeProjects">
                <v-card>
                    <v-card-title>
                        <v-icon class="mr-1" size="20">{{ projectIcon(project) }}</v-icon>
                        {{ project.name }}
                    </v-card-title>
                    <v-card-subtitle>
                        <a :href="project.url" class="body-2 external-link" style="text-decoration: none;"
                           target="_blank">
                            <v-icon color="secondary" style="text-decoration: none;">mdi-link</v-icon>
                            {{ project.url }}
                        </a>
                    </v-card-subtitle>
                    <v-card-text>
                        <v-layout class="flex justify-start">
                            <v-text-field :value="projectFullToken(project)" dense filled hide-details
                                          label="Project Token"
                                          readonly/>
                            <v-btn @click="doCopy(projectFullToken(project))" class="mt-3" text>Copy!</v-btn>
                        </v-layout>
                    </v-card-text>
                    <v-card-actions>
                        <v-list-item class="grow">
                            <v-row align="center" justify="end">
                                <v-btn @click="editingProject = project" color="primary" small text>
                                    <v-icon>mdi-pencil</v-icon>
                                </v-btn>
                                <v-btn @click="archive(project)" color="red" small text>
                                    <v-icon>mdi-archive-arrow-down</v-icon>
                                </v-btn>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <h2 class="d-block pt-12" v-if="archivedProjects.length">Archived projects</h2>
        <v-row v-if="archivedProjects.length">
            <v-col :key="project.id" cols="12" lg="4" sm="6" v-for="project in archivedProjects">
                <v-card>
                    <v-card-title>
                        <v-icon class="mr-1" size="20">{{ projectIcon(project) }}</v-icon>
                        {{ project.name }}
                    </v-card-title>
                    <v-card-subtitle>
                        <a :href="project.url" class="body-2 external-link" style="text-decoration: none;"
                           target="_blank">
                            <v-icon color="secondary" style="text-decoration: none;">mdi-link</v-icon>
                            {{ project.url }}
                        </a>
                    </v-card-subtitle>
                    <v-card-actions>
                        <v-list-item class="grow">
                            <v-row align="center" justify="end">
                                <v-btn @click="unarchive(project)" color="primary" text>
                                    <v-icon>mdi-archive-arrow-up</v-icon>
                                </v-btn>
                            </v-row>
                        </v-list-item>
                    </v-card-actions>
                </v-card>
            </v-col>
        </v-row>

        <v-dialog v-model="newProjectDialog" width="800px">
            <v-card>
                <v-card-title class="secondary white--text">Create project</v-card-title>
                <v-container>
                    <v-form @keyup.native.enter="create" autocomplete="off" class="pa-2"
                            lazy-validation ref="newProjectForm" v-model="newProjectFormValid">
                        <v-text-field :rules="[rules.required('Name is required')]" autocapitalize="none"
                                      autocorrect="off" placeholder="Name"
                                      required v-model="newProject.name"/>
                        <v-text-field :rules="[rules.required('URL is required'), rules.url]" autocapitalize="none"
                                      autocorrect="off" placeholder="URL"
                                      required v-model="newProject.url"/>
                        <v-select :items="projectAvailablePlatforms()" :rules="[rules.required('Platform is required')]"
                                  item-text="name" item-value="name" label="Platform" v-model="newProject.platform"/>
                    </v-form>
                </v-container>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="newProjectDialog = false; $refs.newProjectForm.reset()" text>Cancel</v-btn>
                    <v-btn :disabled="!newProjectFormValid || loading" :loading="loading" @click="create"
                           color="primary">Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <v-dialog v-if="editingProject" v-model="editingProject" width="800px">
            <v-card>
                <v-card-title class="secondary white--text">Edit project</v-card-title>
                <v-container>
                    <v-form @keyup.native.enter="edit" autocomplete="off" class="pa-2"
                            lazy-validation ref="editProjectForm" v-model="editProjectFormValid">
                        <v-text-field :rules="rules.name" autocapitalize="none" autocorrect="off" placeholder="Name"
                                      required v-model="editingProject.name"/>
                        <v-text-field :rules="rules.url" autocapitalize="none" autocorrect="off" placeholder="URL"
                                      required v-model="editingProject.url"/>
                        <v-select :items="projectAvailablePlatforms()" :rules="[rules.required('Platform is required')]"
                                  item-text="name" item-value="name" label="Platform"
                                  v-model="editingProject.platform"/>
                    </v-form>
                </v-container>
                <v-card-actions>
                    <v-spacer/>
                    <v-btn @click="editingProject = null" text>Cancel</v-btn>
                    <v-btn :disabled="!editProjectFormValid || loading" :loading="loading" @click="edit"
                           color="primary">Save
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-container>
</template>

<script>
    import {mapMutations} from 'vuex';

    export default {
        name: "ProjectsList",
        data: () => ({
            loading: false,
            newProjectDialog: false,
            newProject: {
                name: '',
                url: '',
                platform: '',
            },
            newProjectFormValid: false,
            rules: {
                required: msg => v => !!v || msg,
                url: v => /^(?:(?:https?):\/\/)(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,}))\.?)(?::\d{2,5})?(?:[/?#]\S*)?$/i.test(v) || 'Invalid URL',
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
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
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
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
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
                        this.list();
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
            archive(project) {
                this.$store.dispatch('projects/archive', project.id)
                    .then(response => {
                        this.list();
                    })
                    .catch(error => {
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
                    });
            },
            unarchive(project) {
                this.$store.dispatch('projects/unarchive', project.id)
                    .then(response => {
                        this.list();
                    })
                    .catch(error => {
                        this.setSnackMessage({
                            message: "Unexpected error occurred. Please, try again.",
                            color: "error"
                        });
                    });
            },
            projectIcon(project) {
                const filtered = this.projectAvailablePlatforms().filter((platform) => platform.name === project.platform);
                if (!filtered.length) {
                    return '';
                }

                return filtered[0].icon;
            },
            projectFullToken(project) {
                return `${project.id}:${project.token}@atalaya.tech`;
            },
            projectAvailablePlatforms() {
                return this.$store.getters['projects/getAvailablePlatforms'];
            },
            doCopy(text) {
                this.$copyText(text).then(function (e) {
                    alert('Copied!');
                }, function (e) {
                    alert('Cannot copy :(');
                })
            },
            ...mapMutations({
                setSnackMessage: 'setSnackMessage'
            })
        }
    }
</script>

<style scoped>
    .external-link {
        color: #607d8b;
    }
</style>
