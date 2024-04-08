import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {

    try {
        const token  = useCookie('token').value
        console.log(token)
        if (token) {
            if (!useAppStore().user) {
                const user = await axios.get('/api/user').then(response => {
                    useAppStore().user = response.data;
                })
            }
        }

    }catch (error) {
        // @ts-ignore
        if (error.response?.status === 401){
            useAppStore().user = null
            // return navigateTo('/login')
            console.log('error')
        }
    }

})
