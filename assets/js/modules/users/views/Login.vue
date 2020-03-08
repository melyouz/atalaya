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
    <v-container fill-height>
        <v-layout align-center row wrap>
            <v-flex class="xs12 text-xs-center">
                <v-form
                    @keyup.native.enter="submit"
                    aria-autocomplete
                    autocomplete="off"
                    lazy-validation
                    ref="form"
                    v-model="valid"
                >
                    <v-text-field
                        :rules="rules.email"
                        autocapitalize="none"
                        autocorrect="off"
                        label="Email"
                        required
                        v-model="formData.email"
                    ></v-text-field>

                    <v-text-field
                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        :rules="rules.password"
                        :type="showPassword ? 'text' : 'password'"
                        @click:append="showPassword = !showPassword"
                        autocapitalize="none"
                        autocorrect="off"
                        label="Password"
                        required
                        v-model="formData.password"
                    ></v-text-field>

                    <v-btn
                        :disabled="!valid || loading"
                        :loading="loading"
                        @click="submit"
                        block
                        color="primary"
                        large
                    >Log in
                    </v-btn>
                </v-form>

            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    import {mapMutations} from 'vuex';

    export default {
        name: "Login",
        data: () => ({
            valid: true,
            showPassword: false,
            loading: false,
            formData: {
                email: "",
                password: ""
            },
            rules: {
                email: [
                    v => !!v || 'Email is required',
                    v => /.+@.+/.test(v) || 'Invalid Email',
                ],
                password: [v => !!v || "Password is required"],
            }
        }),
        methods: {
            showPasswordCallback() {
                console.log(this.showPassword);
            },
            submit() {
                if (!this.$refs.form.validate()) return;
                this.loading = true;
                this.$store.dispatch('users/login', this.formData)
                    .then(response => {
                        const nextUrl = this.$route.params.nextUrl || {name: "homepage"};
                        this.$router.push(nextUrl);
                    })
                    .catch(error => {
                        if (error.response.status === 401) {
                            this.setSnackMessage({message: "Invalid credentials.", color: "error"});
                        }
                        if (error.response.status === 500) {
                            this.setSnackMessage({
                                message: "Unexpected error occurred. Please, try again later.",
                                color: "error"
                            });
                        }
                    })
                    .then(() => {
                        this.loading = false;
                    });
            },
            ...mapMutations({
                setSnackMessage: 'setSnackMessage'
            })
        }
    }
</script>

<style lang="scss" scoped>
    .container {
        max-width: 800px !important;
    }
</style>
