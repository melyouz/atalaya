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
            <v-flex class="text-xs-center" md6 offset-md3 offset-sm2 sm8 xs12>
                <h1>This page is not available.</h1>
                <p>Perhaps the link you have followed is incorrect or the page has been deleted. Return to
                    <router-link :to="{name: 'homepage'}">Home</router-link>
                    .
                </p>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>
    export default {
        name: "NotFound"
    }
</script>

<style scoped>

</style>
