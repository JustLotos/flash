<template>
    <v-main class="text-center" fill-height style="height: calc(100vh - 58px);">
        <v-row align="center">
            <v-col>
                <h1 class="display-2 primary--text">Whoops, 404</h1>
                <p>The page you were looking for does not exist</p>
                <v-btn color="primary" outlined :to="{name: 'Home'}">Get me out of here!</v-btn>
            </v-col>
        </v-row>
    </v-main>
</template>
<script lang="ts">
import { Component, Vue } from "vue-property-decorator";
@Component
export default class NotFoundPage extends Vue{}
</script>