<template>
    <div class="row justify-content-center mt-5">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="card shadow">
          <div class="card-title text-center border-bottom">
            <h2 class="p-3">Shortener</h2>
          </div>
          <div class="card-body">
            <form pre>
              <div class="mb-4">
                <label for="username" class="form-label">Email</label>
                <input type="text" class="form-control" v-model.trim="form.email" />
              </div>
              <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" v-model.trim="form.password"/>
              </div>
              <div v-if="errors.failLogin">
                Usuario y/o contraseña incorrecto/s
              </div>
              <div class="d-grid">
                <button type="button" class="btn text-light btn-info" @click="submit">Login</button>
              </div>
            </form>
          </div>
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
        const errors = reactive({
          failLogin: false
        })
        const form = reactive({
            email: '',
            password: ''
        })
        const submit = async () => {
            errors.failLogin = false
            if(!form.email){
                return alert('Email required')
            }
            if(!form.password){
                return alert('Password required')
            }
            let loggedIn = await common.login({'email': form.email, 'password': form.password})
            if(!loggedIn){
              errors.failLogin = true
              return
            }

            router.push('/')
            
        }
        return { submit, form, errors }
    }
}
</script>