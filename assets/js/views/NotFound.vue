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
        <v-row class="text-center align-center">
            <v-col>
                <h1 class="display-2 primary--text">Whoops, this page is not available.</h1>
                <p class="pt-2">Perhaps the link you have followed is incorrect or the page has been deleted.</p>
                <v-btn :to="{name: 'homepage'}" color="primary">
                    Return to Home
                </v-btn>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
    export default {
        name: "NotFound"
    }
</script>

<style scoped>

</style>
