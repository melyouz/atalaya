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
    <v-snackbar :color="color" top v-model="show">
        {{message}}
    </v-snackbar>
</template>

<script>
    export default {
        name: "Snackbar",
        data() {
            return {
                show: false,
                color: '',
                message: '',
            }
        },
        created: function () {
            this.$store.watch(state => state.snackMessage, () => {
                const snackMessage = this.$store.getters.getSnackMessage;
                if (snackMessage !== null) {
                    this.message = snackMessage.message;
                    this.color = snackMessage.color;
                    this.show = true;
                    this.$store.commit('setSnackMessage', null);
                }
            })
        }
    }
</script>

<style scoped>

</style>
