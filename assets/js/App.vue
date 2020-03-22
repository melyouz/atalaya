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
    <div class="page-container">
        <v-app>
            <v-navigation-drawer :clipped="$vuetify.breakpoint.lgAndUp" app v-if="loggedIn" v-model="menuVisible">
                <v-layout column fill-height>
                    <v-list>
                        <v-list-item link>
                            <v-list-item-avatar>
                                <v-gravatar :email="user.email" default-img="mm"/>
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item-title class="title">{{ user.name }}</v-list-item-title>
                                <v-list-item-subtitle>{{ user.email }}</v-list-item-subtitle>
                            </v-list-item-content>

                            <v-list-item-action>
                                <v-icon>mdi-menu-down</v-icon>
                            </v-list-item-action>
                        </v-list-item>
                    </v-list>
                    <v-divider/>
                    <v-list dense nav>
                        <v-list-item-group color="primary">
                            <v-list-item :to="{ name: 'projects-list' }" link>
                                <v-list-item-action>
                                    <v-icon>mdi-folder-multiple</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>Projects</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                            <v-list-item :to="{ name: 'issues-list' }"  link>
                                <v-list-item-action>
                                    <v-icon>mdi-bug-check</v-icon>
                                </v-list-item-action>
                                <v-list-item-content>
                                    <v-list-item-title>Issues</v-list-item-title>
                                </v-list-item-content>
                            </v-list-item>
                        </v-list-item-group>
                    </v-list>
                    <v-spacer/>
                    <v-divider/>
                    <v-list dense nav>
                        <v-list-item :to="{ name: 'users-logout' }" color="primary" link>
                            <v-list-item-action>
                                <v-icon>mdi-logout</v-icon>
                            </v-list-item-action>
                            <v-list-item-content>
                                <v-list-item-title>Logout</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-layout>
            </v-navigation-drawer>

            <v-app-bar :clipped-left="$vuetify.breakpoint.lgAndUp" app color="primary" dark>
                <v-app-bar-nav-icon @click.stop="menuVisible = !menuVisible" class="pr-4" v-if="loggedIn"/>
                <v-toolbar-title class="ml-0">
                    <router-link :to="{ name: 'homepage'}">
                        <v-img :alt="appName" :src="require('@images/Atalaya_white.svg')" max-width="150"/>
                    </router-link>
                </v-toolbar-title>
            </v-app-bar>

            <v-content>
                <router-view :key="$route.fullPath"/>
                <Snackbar/>
            </v-content>
            <v-footer app color="primary">
                <v-row>
                    <v-col class="mx-auto" cols="auto">
                        <span class="white--text body-2">&copy; {{(new Date()).getFullYear()}} Atalaya. All rights reserved.</span>
                    </v-col>
                </v-row>
            </v-footer>
        </v-app>
    </div>
</template>

<script>
    import Snackbar from './components/Snackbar'

    export default {
        name: "App",
        data: () => ({
            menuVisible: true,
            appName: "Atalaya",
            appVersion: "v0.7",
        }),
        methods: {},
        computed: {
            loggedIn() {
                return this.$store.getters['users/isLoggedIn']
            },
            user() {
                return this.$store.getters['users/getUser'];
            },
        },
        components: {Snackbar},
    }
</script>

<style lang="scss">
    .v-toolbar__title {
        cursor: pointer;
    }
</style>
