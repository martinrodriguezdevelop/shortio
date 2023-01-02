import { defineStore } from "pinia";
import { api } from "../boot/axios";


export const useCommonStore = defineStore("common", {
  state: () => ({
    logged: true,
    token: null
  }),

  getters: {
    isLoggedIn(state) {
        return state.logged;
    },
  },

  actions: {
    async login(values) {
        return await api.post('oauth/token', {
            "client_id":"1",
            "client_secret":"V1I14wTdHTut0DbHnd8j9nneyvRydLcw0yQXn3BK",
            "grant_type":"client_credentials"
        }).then(rs => {
            return api.post('/api/login', values, {
                headers: {
                    'Authorization': 'Bearer '+rs.data.access_token
                }
            })
        }).then(rs => {
            if(rs.status == 200){
                this.logged = true
                return true
            }
            return false
        }).catch((err) => { 
            return false
        })
    },
    getClientRequestToken(){
        return api.post('oauth/token', {
            "client_id":"1",
            "client_secret":"V1I14wTdHTut0DbHnd8j9nneyvRydLcw0yQXn3BK",
            "grant_type":"client_credentials"
        }).then(rs => {
            this.token = rs.data.access_token
        })
    },
    short(values) {
        return api.post('/api/shorten', values, {
            headers: {
                'Authorization': 'Bearer '+ this.token
            }
        })
    },
    logout() {
        this.logged = false
    }
  },
});
