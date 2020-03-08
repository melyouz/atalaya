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

</template>

<script>
    export default {
        name: "Logout",
        created() {
            this.$store.dispatch('users/logout').then(() => {
                this.$router.push({name: 'users-login'});
            });
        }
    }
</script>

<style scoped>

</style>
