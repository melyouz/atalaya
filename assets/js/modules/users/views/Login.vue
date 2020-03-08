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
        <v-layout row wrap align-center>
            <v-flex class="xs12 text-xs-center">
                <v-form
                    @keyup.native.enter="submit"
                    ref="form"
                    v-model="valid"
                    lazy-validation
                    aria-autocomplete
                    autocomplete="off"
                >
                    <v-text-field
                        v-model="formData.email"
                        :rules="rules.email"
                        label="Email"
                        required
                        autocorrect="off"
                        autocapitalize="none"
                    ></v-text-field>

                    <v-text-field
                        v-model="formData.password"
                        required
                        :append-icon="showPassword ? 'mdi-eye-off' : 'mdi-eye'"
                        :type="showPassword ? 'text' : 'password'"
                        @click:append="showPassword = !showPassword"
                        :rules="rules.password"
                        label="Password"
                        autocorrect="off"
                        autocapitalize="none"
                    ></v-text-field>

                    <v-btn
                        large
                        block
                        color="primary"
                        @click="submit"
                        :disabled="!valid || loading"
                        :loading="loading"
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
                            this.setSnackMessage({message: "Unexpected error occurred. Please, try again later.", color: "error"});
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

<style scoped lang="scss">
    .container {
        max-width: 800px !important;
    }
</style>
