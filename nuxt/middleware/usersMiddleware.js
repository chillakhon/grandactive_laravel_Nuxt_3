import axios from "axios";
import {useAppStore} from "~/store";

export default defineNuxtRouteMiddleware(async (to, from) => {

    try {
        if (!useAppStore().users) {
            await axios.get('api/users').then(res => {
                useAppStore().users = res.data
            });
        }

    }catch (error) {

    }

})
