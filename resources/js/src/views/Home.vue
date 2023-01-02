<template>
    <div class="row justify-content-center mt-5">
        <a href="" @click="logout">Logout</a>
        <div class="col-lg-8 col-md-10 col-sm-10">
            <div class="card">
                <div class="card-title text-center">
                <h2 class="p-3">Shortener</h2>
                </div>
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" placeholder="Url to shorten" v-model.trim="form.url"/>
                <button class="btn text-light btn-success" @click="submit">Short url!</button>
            </div>
            <div class="mb-4" v-if="Object.values(responseMessage.txt).length > 0">
                <a :href="currentUrl+responseMessage.txt.short_url" target="_blank">
                    {{ currentUrl+responseMessage.txt.short_url }}
                </a>
            </div>
            
        </div>
    </div>
</template>
<script>
import { reactive } from "vue";
import { useCommonStore } from "../stores/index";
import router from "../router/index"

export default{
    setup () {
        const common = useCommonStore();
        const currentUrl = window.location.href;
        const responseMessage = reactive({
            txt: {}
        })
        const form = reactive({
            url: '',
        })
        const submit = () => {
            if(!form.url){
                return alert('Url required')
            }
            common.short(form).then((rs)=>{
                responseMessage.txt = rs.data;
            });
            
        }
        const logout = () => {
            common.logout()
            router.push('login')
        }
        const prettyJson = (value) => {
            return JSON.stringify(value, null, 2)
        }
        return { submit, form, responseMessage, prettyJson, currentUrl, logout }
    }
}
</script>