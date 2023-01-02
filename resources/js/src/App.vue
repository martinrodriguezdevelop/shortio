<template>
    <div class="container">
        <router-view/>
    </div>
</template>
<script setup>
import { useCommonStore } from "./stores/index";

const common = useCommonStore();

common.getClientRequestToken()

</script>