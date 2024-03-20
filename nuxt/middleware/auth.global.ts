import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {

    try {
        const user = await axios.get('/api/user')
        if (user.data) {
            useAppStore().user = user.data
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
